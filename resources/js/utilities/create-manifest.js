import { writeFileSync, existsSync } from "fs";
import { compileString } from "sass";
import { resolve } from "path";
import { createRequire } from "module";

async function generateManifest() {
    try {
        const viteManifest = getViteManifest();
        const themeColors = getThemeColors();

        const manifest = {
            name: "Starter",
            short_name: "Starter",
            start_url: "/",
            display: "standalone",
            background_color: themeColors.background,
            theme_color: themeColors.theme,
            orientation: "portrait-primary",
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

function generateIcons(viteManifest) {
    const icons = [
        {
            src: "resources/images/icons/mstile-150x150.webp",
            type: "image/webp",
            sizes: "150x150",
            purpose: "any",
        },
        {
            src: "resources/images/icons/mstile-150x150.png",
            type: "image/png",
            sizes: "150x150",
            purpose: "any",
        },
        {
            src: "resources/images/icons/icon-192x192.webp",
            type: "image/webp",
            sizes: "192x192",
            purpose: "any",
        },
        {
            src: "resources/images/icons/icon-192x192.png",
            type: "image/png",
            sizes: "192x192",
            purpose: "any",
        },
        {
            src: "resources/images/icons/icon-512x512.webp",
            type: "image/webp",
            sizes: "512x512",
            purpose: "any",
        },
        {
            src: "resources/images/icons/icon-512x512.png",
            type: "image/png",
            sizes: "512x512",
            purpose: "any",
        },
    ];

    return icons.map((icon) => {
        const fileName = icon.src.split("/").pop();
        const hashedFile = viteManifest[`resources/images/icons/${fileName}`];

        if (hashedFile) {
            icon.src = `build/${hashedFile.file}`;
        }

        return icon;
    });
}

/**
 * PWA colors come from the theme tokens, compiled by Sass itself (variable references, functions...):
 * `theme_color` (browser/app bar) = `$ds-primary`, `background_color` (splash screen) = `$ds-body-bg`.
 * The `<meta name="theme-color">` in `<x-frontend::pwa />` reads `theme_color` from the generated manifest.
 */
function getThemeColors() {
    const { css } = compileString(
        `
        @use "resources/scss/frontend/tokens/color-tokens" as color;
        @use "resources/scss/frontend/tokens/design-tokens" as design;
        :root { --theme: #{color.$ds-primary}; --background: #{design.$ds-body-bg}; }
        `,
        { loadPaths: [process.cwd()] },
    );

    return {
        theme: css.match(/--theme: ([^;]+);/)[1],
        background: css.match(/--background: ([^;]+);/)[1],
    };
}

generateManifest();
