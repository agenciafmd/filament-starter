import { writeFileSync, existsSync } from "fs";
import { compileString } from "sass";
import { resolve } from "path";
import { createRequire } from "module";

/**
 * PWA manifest (public/manifest.json): name, colors and icons used when the site is installed
 * (home screen, app list). Runs after `npm run build` (or alone with `npm run pwa`).
 */

// =============================================================================================
// PROJECT SETTINGS: adjust them for each project
// =============================================================================================

// Name shown when the site is installed. Change it in every project
const app = {
    name: "Starter",
    // Under the icon on the home screen: keep it short (up to ~12 characters)
    shortName: "Starter",
    startUrl: "/",
    display: "standalone",
    orientation: "portrait-primary",
};

// Icons of resources/images/icons, each one in webp and png (sizes = the size of the file)
const icons = [
    { file: "mstile-150x150", sizes: "150x150" },
    { file: "icon-192x192", sizes: "192x192" },
    { file: "icon-512x512", sizes: "512x512" },
];

// The colors come from the theme tokens (see getThemeColors below)

// =============================================================================================
// BUILD INFRASTRUCTURE: no need to change it
// =============================================================================================

const iconsFolder = "resources/images/icons";

const iconFormats = [
    { extension: "webp", type: "image/webp" },
    { extension: "png", type: "image/png" },
];

async function generateManifest() {
    try {
        const viteManifest = getViteManifest();
        const themeColors = getThemeColors();

        const manifest = {
            name: app.name,
            short_name: app.shortName,
            start_url: app.startUrl,
            display: app.display,
            background_color: themeColors.background,
            theme_color: themeColors.theme,
            orientation: app.orientation,
            icons: generateIcons(viteManifest),
        };

        const outputPath = resolve("public/manifest.json");

        writeFileSync(outputPath, JSON.stringify(manifest, null, 2), "utf8");
        console.log(
            `✅  PWA manifest successfully generated! File path: ${outputPath}`,
        );
    } catch (error) {
        console.error(
            `⚠️  Oops! Something went wrong while generating the manifest: ${error.message}`,
        );
    }
}

function getViteManifest() {
    const require = createRequire(import.meta.url);
    const manifestPath = resolve("public/build/manifest.json");

    if (!existsSync(manifestPath)) {
        throw new Error(
            `Manifest não encontrado em ${manifestPath}. Certifique-se de que o Build tenha sido executado.`,
        );
    }

    return require(manifestPath);
}

/**
 * Each icon in webp and png (webp first), pointing to the hashed file of the build
 */
function generateIcons(viteManifest) {
    return icons.flatMap(({ file, sizes }) =>
        iconFormats.map(({ extension, type }) => {
            const source = `${iconsFolder}/${file}.${extension}`;
            const hashedFile = viteManifest[source];

            return {
                src: hashedFile ? `build/${hashedFile.file}` : source,
                type,
                sizes,
                purpose: "any",
            };
        }),
    );
}

/**
 * PWA colors come from the theme tokens, compiled by Sass itself (variable references, functions...):
 * `theme_color` (browser/app bar) = `$ds-primary`, `background_color` (splash screen) = `$ds-body-bg`.
 * The `<meta name="theme-color">` in `<x-frontend::pwa />` reads `theme_color` from the generated manifest.
 */
function getThemeColors() {
    const { css } = compileString(
        `
        @import "resources/scss/frontend/tokens/color-tokens";
        @import "resources/scss/frontend/tokens/design-tokens";
        :root { --theme: #{$ds-primary}; --background: #{$ds-body-bg}; }
        `,
        // Bootstrap 5 tokens rely on globals (@import), not on the module system
        { loadPaths: [process.cwd()], silenceDeprecations: ["import"] },
    );

    return {
        theme: css.match(/--theme: ([^;]+);/)[1],
        background: css.match(/--background: ([^;]+);/)[1],
    };
}

generateManifest();
