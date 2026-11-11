/**
 * Critical CSS: the css a page needs to render its first fold, inlined in the <head> by
 * <x-frontend::critical-css>. The full stylesheet then loads without blocking the page.
 *
 * On every `npm run build`, each page of views/html is opened in a real browser (Playwright's
 * Chromium), with its JS running, in the viewports below. What shows up in the first fold
 * is saved to public/css/critical/{page}_critical.min.css.
 */
import { readdirSync } from "fs";
import { readFile, writeFile } from "fs/promises";
import { join } from "path";
import { chromium } from "playwright";
// Not in package.json on purpose: installed by vite and critical
import postcss from "postcss";
import PluginCritical from "rollup-plugin-critical";

// ---------------------------------------------------------------------------------------------
// Settings
// ---------------------------------------------------------------------------------------------

const criticalFolder = "public/css/critical";

const htmlViewsFolder = join(
    import.meta.dirname,
    "../../../packages/agenciafmd/frontend/resources/views/html",
);

// Every page of views/html gets a critical css, except these (layouts and the component catalog)
const ignoredPages = ["internal", "master", "tema"];

// Rules always kept: they depend on states the browser doesn't reach when it opens the page
// (scroll, slider running), but they show up in the first fold
const alwaysIncludedRules = [
    // Color mode, set on <html> by color-mode.blade.php
    /data-bs-theme/,
    // Header classes toggled on scroll (resources/js/components/fmd-header.js)
    /fmd-header-is-(fixed|hidden)/,
    // Swiper classes added once the slider starts
    /swiper-(initialized|horizontal|slide-active|slide-next)/,
    // Aspect ratio of the cards' images
    /\[class\*=ratio-\]/,
];

// One viewport per breakpoint of $grid-breakpoints (resources/scss/frontend/_variables.scss)
const viewports = [
    { width: 375, height: 667 }, // xs
    { width: 768, height: 1024 }, // sm
    { width: 1024, height: 768 }, // md
    { width: 1366, height: 768 }, // lg
    { width: 1920, height: 1080 }, // xl
];

// Time (ms) the page's JS gets to run (slider, header, color mode) before the fold is read
const waitForJsTime = 500;

// ---------------------------------------------------------------------------------------------
// Vite plugin (used in vite.config.js)
// ---------------------------------------------------------------------------------------------

export default function critical(criticalUrl) {
    const pages = listPages();
    const errors = [];

    const plugin = PluginCritical(
        {
            criticalUrl,
            criticalBase: criticalFolder,
            criticalPages: pages,
            criticalConfig: {
                include: alwaysIncludedRules,
                dimensions: viewports,
                penthouse: {
                    blockJSRequests: false,
                    renderWaitTime: waitForJsTime,
                },
            },
        },
        // rollup-plugin-critical only logs its errors: they're kept here to stop the build later
        (error) => {
            if (error) {
                errors.push(error);
            }
        },
    );

    const generateCriticalCss = plugin.writeBundle;

    // Runs once the build has written its files
    plugin.writeBundle = async function (outputOptions, bundle) {
        // 1. The pages are read from the running app: without it, keep the last critical css
        const isReady = await isAppReady(criticalUrl, pages);

        if (!isReady) {
            return;
        }

        // 2. Puppeteer's own Chrome isn't downloaded (its install script is blocked): use Playwright's
        process.env.PUPPETEER_EXECUTABLE_PATH ??= chromium.executablePath();

        // 3. Generate the critical css from the page's stylesheet only
        await generateCriticalCss.call(
            this,
            outputOptions,
            onlyPageStylesheet(bundle),
        );

        // 4. A page without critical css stops the build
        if (errors.length > 0) {
            throw new Error(`CSS crítico: ${errors.join("; ")}`);
        }

        // 5. Remove the repeated rules from each file
        for (const { template } of pages) {
            await removeDuplicatesFromFile(
                `${criticalFolder}/${template}_critical.min.css`,
            );
        }
    };

    return plugin;
}

// ---------------------------------------------------------------------------------------------
// Pages
// ---------------------------------------------------------------------------------------------

/**
 * One item per page of views/html: blog.blade.php → { uri: "blog", template: "blog" }.
 * The template must match the `critical` the page passes ('critical' => 'blog.css').
 */
function listPages() {
    const pages = [];

    for (const file of readdirSync(htmlViewsFolder)) {
        // Folders (partials/) and anything that isn't a view are skipped
        if (!file.endsWith(".blade.php")) {
            continue;
        }

        const page = file.replace(".blade.php", "");

        if (ignoredPages.includes(page)) {
            continue;
        }

        pages.push({
            // index is the root of /html/
            uri: page === "index" ? "" : page,
            template: page,
        });
    }

    return pages;
}

/**
 * Only the page's stylesheet (frontend-*.css) is analysed: the catalog css and the vendor css
 * loaded on demand aren't on these pages.
 */
function onlyPageStylesheet(bundle) {
    const pageStylesheet = {};

    for (const [file, asset] of Object.entries(bundle)) {
        if (/\/frontend-[^/]+\.css$/.test(file)) {
            pageStylesheet[file] = asset;
        }
    }

    return pageStylesheet;
}

// ---------------------------------------------------------------------------------------------
// App check
// ---------------------------------------------------------------------------------------------

/**
 * - App down (CI, composer setup, Sail stopped): warns and returns false.
 *   The critical css of the last build stays as it is.
 * - App up but a page doesn't answer 200: stops the build. A 3xx (production redirects /html/)
 *   or an error page would become that page's critical css.
 * - Every page answers 200: returns true.
 */
async function isAppReady(criticalUrl, pages) {
    for (const { uri } of pages) {
        const url = `${criticalUrl}${uri}`;
        let response;

        try {
            response = await fetch(url, { redirect: "manual" });
        } catch (error) {
            console.warn(
                `\x1b[33mCSS crítico não regerado: ${url} não respondeu (${error.cause?.code ?? error.message}). Os arquivos de ${criticalFolder} continuam os do último build.\x1b[0m`,
            );

            return false;
        }

        // Only the status is used: an unread body left open makes Node crash when the build ends
        await response.body?.cancel();

        if (response.status !== 200) {
            throw new Error(
                `CSS crítico: ${url} respondeu ${response.status} em vez de 200 (3xx: APP_ENV=production redireciona /html/; 5xx: erro na view).`,
            );
        }
    }

    return true;
}

// ---------------------------------------------------------------------------------------------
// Removing duplicates
// ---------------------------------------------------------------------------------------------

// Besides the rules, these at-rules are also removed when repeated
const atRulesToDeduplicate = ["font-face", "keyframes", "property"];

/**
 * critical joins the css of the 5 viewports, but doesn't remove the rules repeated inside
 * @layer blocks: the same rule can show up once per viewport.
 */
async function removeDuplicatesFromFile(file) {
    const css = await readFile(file, "utf8");

    await writeFile(file, removeDuplicates(css));
}

/**
 * Two rules are the same when the text and the context (@layer, @media around them) match:
 * `.btn{...}` inside @media (width>=992px) isn't a copy of `.btn{...}` outside it.
 *
 * Of the copies, the last one stays: in css, the last rule wins, so the result doesn't change.
 */
function removeDuplicates(css) {
    const root = postcss.parse(css);
    const lastCopyOf = new Map();

    root.walk((node) => {
        const isRule = node.type === "rule";
        const isDeduplicatedAtRule =
            node.type === "atrule" && atRulesToDeduplicate.includes(node.name);

        if (!isRule && !isDeduplicatedAtRule) {
            return;
        }

        const key = `${contextOf(node)} | ${node.toString()}`;
        const previousCopy = lastCopyOf.get(key);

        if (previousCopy) {
            previousCopy.remove();
        }

        lastCopyOf.set(key, node);
    });

    removeEmptyBlocks(root);

    return root.toString();
}

/**
 * The at-rules around a node, from the outside in: "@layer components > @media (width>=992px)"
 */
function contextOf(node) {
    const atRules = [];
    let parent = node.parent;

    while (parent && parent.type === "atrule") {
        atRules.unshift(`@${parent.name} ${parent.params}`);
        parent = parent.parent;
    }

    return atRules.join(" > ");
}

/**
 * Removes the @layer/@media left empty after removing the copies.
 * Goes from the last to the first, so the inner blocks are removed before the outer ones:
 * `@layer x { @media y {} }` → `@layer x {}` → removed too.
 */
function removeEmptyBlocks(root) {
    const blocks = [];

    root.walkAtRules((atRule) => {
        blocks.push(atRule);
    });

    for (const block of blocks.reverse()) {
        const isEmpty = block.nodes && block.nodes.length === 0;

        if (isEmpty) {
            block.remove();
        }
    }
}
