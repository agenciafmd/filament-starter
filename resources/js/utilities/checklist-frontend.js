/**
 * Frontend checklist: checks the items reviewed before delivering a site and writes a report.
 *
 *   vendor/bin/sail npm run checklist-frontend
 *
 * Needs the app running (Sail) and a build (`npm run build`). Each page of views/html (the same
 * list as the critical css) is opened in Chromium, Firefox and WebKit (Safari's engine).
 * The terminal shows ✓ / ⚠ / ✗ per item and the exit code is 1 when something fails.
 * The report (screenshots, Lighthouse) is written to public/checklist-frontend/ (ignored by git)
 * and the terminal prints its url, served by the app itself, to open it from the host.
 */
import { execFileSync } from "child_process";
import { existsSync } from "fs";
import { rm, mkdir } from "fs/promises";
import { chromium, firefox, webkit } from "playwright";
import { loadEnv } from "vite";
import { listPages, viewports } from "./critical.js";
import checkBrowsers from "./checklist/browsers.js";
import checkCritical from "./checklist/critical.js";
import checkFonts from "./checklist/fonts.js";
import checkLighthouse from "./checklist/lighthouse.js";
import checkPrivacy from "./checklist/privacy.js";
import checkPwa from "./checklist/pwa.js";
import writeReport from "./checklist/report.js";

// =============================================================================================
// PROJECT SETTINGS: adjust them for each project
// =============================================================================================

// Real routes checked besides the pages of views/html (e.g. "/", "/contato").
// Add them once the site has its own routes: they don't get critical css checked
const extraUrls = [];

// Browsers of the compatibility and breakpoint checks. WebKit is the engine of Safari
const browsers = ["chromium", "firefox", "webkit"];

// Console errors that don't fail the checklist. Keep only known bugs, with the reason
const ignoredConsoleErrors = [
    // Bootstrap 6.0.0-alpha.1: the Combobox creates a second Menu on the same element (works anyway)
    /more than one instance per element\. Bound instance: bs\.combobox/,
];

// Minimum Lighthouse score (0-100) per category
const lighthouseThresholds = {
    performance: 80,
    accessibility: 90,
    "best-practices": 90,
    seo: 90,
};

// The local server doesn't compress the assets, so the local performance score is lower than in
// production: below the minimum it's a warning (⚠). Set true to fail (e.g. against a staging url)
const performanceFailsBelowThreshold = false;

// Url of the privacy policy. Empty: the checklist looks for the link in the pages by its text
const privacyPolicyUrl = "";

// Text of the privacy policy link (text, title or aria-label)
const privacyLinkText = /pol[ií]tica de privacidade|privacidade|termos/i;

// =============================================================================================
// BUILD INFRASTRUCTURE: no need to change it
// =============================================================================================

// Inside public/ so the app serves it: the container has no browser to open a local file
const reportFolder = "public/checklist-frontend";

const browserTypes = { chromium, firefox, webkit };

const statusIcons = { pass: "✓", warn: "⚠", fail: "✗" };
const statusColors = { pass: "\x1b[32m", warn: "\x1b[33m", fail: "\x1b[31m" };
const resetColor = "\x1b[0m";

const appUrl = new URL(
    loadEnv(process.env.NODE_ENV ?? "production", process.cwd(), ["APP"])
        .APP_URL || "http://localhost",
);

// Same url as the critical css (vite.config.js): without the port, because the checklist runs
// inside the Sail container, where the app listens on port 80
const getBaseUrl = () => `${appUrl.protocol}//${appUrl.hostname}`;

// The report as the host sees it: APP_URL with its port (e.g. http://localhost:8081)
const getReportUrl = () =>
    `${appUrl.origin}/${reportFolder.replace(/^public\//, "")}/index.html`;

function getPages(baseUrl) {
    const htmlPages = listPages().map(({ uri, template }) => ({
        name: template,
        url: `${baseUrl}/html/${uri}`,
        template,
    }));

    const routePages = extraUrls.map((path) => ({
        name: path,
        url: `${baseUrl}${path}`,
        template: null,
    }));

    return [...htmlPages, ...routePages];
}

/**
 * Stops with a clear message when the checklist can't run: vite dev running, no build, app down
 */
async function checkPreconditions(pages) {
    if (existsSync("public/hot")) {
        throw new Error(
            "O `npm run dev` está rodando (public/hot existe): pare o servidor do Vite e rode `npm run build`, porque o checklist verifica o build.",
        );
    }

    if (!existsSync("public/build/manifest.json")) {
        throw new Error("Build não encontrado: rode `npm run build` antes.");
    }

    for (const { url } of pages) {
        let response;

        try {
            response = await fetch(url, { redirect: "manual" });
        } catch (error) {
            throw new Error(
                `${url} não respondeu (${error.cause?.code ?? error.message}). Suba o app com \`vendor/bin/sail up -d\`.`,
            );
        }

        await response.body?.cancel();

        if (response.status !== 200) {
            throw new Error(
                `${url} respondeu ${response.status} em vez de 200 (3xx: APP_ENV=production redireciona /html/; 5xx: erro na view).`,
            );
        }
    }
}

/**
 * Firefox and WebKit are only downloaded by the checklist: the postinstall downloads Chromium only
 */
async function installMissingBrowsers() {
    const missing = browsers.filter(
        (name) => !existsSync(browserTypes[name].executablePath()),
    );

    if (missing.length === 0) {
        return;
    }

    console.log(`Instalando navegadores do Playwright: ${missing.join(", ")}…`);

    execFileSync("npx", ["playwright", "install", ...missing], {
        stdio: "inherit",
    });
}

function printResults(results) {
    let currentItem = "";

    for (const { item, target, status, details } of results) {
        if (item !== currentItem) {
            console.log(`\n${item}`);
            currentItem = item;
        }

        console.log(
            `  ${statusColors[status]}${statusIcons[status]}${resetColor} ${target}`,
        );

        for (const detail of details) {
            console.log(`      ${detail}`);
        }
    }

    const count = (status) =>
        results.filter((result) => result.status === status).length;

    console.log(
        `\n${count("pass")} ok, ${count("warn")} avisos, ${count("fail")} falhas`,
    );
}

async function run() {
    const baseUrl = getBaseUrl();
    const pages = getPages(baseUrl);

    await checkPreconditions(pages);
    await installMissingBrowsers();

    await rm(reportFolder, { recursive: true, force: true });
    await mkdir(reportFolder, { recursive: true });

    const context = {
        baseUrl,
        pages,
        reportFolder,
        browsers: browsers.map((name) => ({ name, type: browserTypes[name] })),
        viewports,
        ignoredConsoleErrors,
        lighthouseThresholds,
        performanceFailsBelowThreshold,
        privacyPolicyUrl,
        privacyLinkText,
    };

    const checks = [
        ["PWA e favicon", checkPwa],
        ["Fontes", checkFonts],
        ["Critical CSS", checkCritical],
        ["Política de privacidade", checkPrivacy],
        ["Navegadores e breakpoints", checkBrowsers],
        ["Lighthouse", checkLighthouse],
    ];

    const results = [];

    for (const [label, check] of checks) {
        console.log(`Verificando: ${label}…`);
        results.push(...(await check(context)));
    }

    printResults(results);

    await writeReport(results, context);

    console.log(`\nRelatório: ${getReportUrl()}`);

    return results.some((result) => result.status === "fail") ? 1 : 0;
}

run()
    .then((exitCode) => process.exit(exitCode))
    .catch((error) => {
        console.error(`\x1b[31m✗ ${error.message}${resetColor}`);
        process.exit(1);
    });
