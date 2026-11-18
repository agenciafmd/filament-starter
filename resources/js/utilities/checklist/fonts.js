/**
 * Fonts: every @font-face loads, the font files answer 200 and come from the build
 * (vite-plugin-webfont-dl), and the body font is a loaded web font
 */
import { chromium } from "playwright";
import { createResult, statusOf, openPage } from "./results.js";

const item = "Fontes";

// The external font is downloaded at build time: a request to these hosts means it isn't
const externalFontHosts = /fonts\.(googleapis|gstatic)\.com/;

/**
 * Runs in the page: font faces that failed and whether the body font is a loaded web font
 */
async function readFontsInPage() {
    await document.fonts.ready;

    const faces = [...document.fonts];
    const bodyStyle = getComputedStyle(document.body);
    const bodyFamily = bodyStyle.fontFamily
        .split(",")[0]
        .trim()
        .replace(/["']/g, "");
    const fontShorthand = `${bodyStyle.fontWeight} 1em "${bodyFamily}"`;

    await document.fonts.load(fontShorthand).catch(() => null);

    return {
        bodyFamily,
        failedFaces: faces
            .filter((face) => face.status === "error")
            .map(
                (face) => `${face.family.replace(/["']/g, "")} ${face.weight}`,
            ),
        isBodyFamilyDeclared: faces.some(
            (face) => face.family.replace(/["']/g, "") === bodyFamily,
        ),
        isBodyFontLoaded: document.fonts.check(fontShorthand),
    };
}

export default async function checkFonts({ pages }) {
    const browser = await chromium.launch();
    const results = [];

    try {
        for (const { name, url } of pages) {
            const page = await browser.newPage();
            const failedFontRequests = [];
            const externalFontRequests = [];

            page.on("response", (response) => {
                if (
                    response.request().resourceType() === "font" &&
                    response.status() >= 400
                ) {
                    failedFontRequests.push(
                        `${response.url()} (${response.status()})`,
                    );
                }
            });

            page.on("request", (request) => {
                if (externalFontHosts.test(request.url())) {
                    externalFontRequests.push(request.url());
                }
            });

            await openPage(page, url);

            const fonts = await page.evaluate(readFontsInPage);
            const fails = [];
            const warnings = [];

            for (const face of fonts.failedFaces) {
                fails.push(`@font-face com erro: ${face}`);
            }

            for (const request of failedFontRequests) {
                fails.push(`fonte não carregou: ${request}`);
            }

            for (const request of externalFontRequests) {
                fails.push(
                    `fonte externa em tempo de execução (deveria vir do build): ${request}`,
                );
            }

            if (!fonts.isBodyFamilyDeclared) {
                warnings.push(
                    `a fonte do body ("${fonts.bodyFamily}") não tem @font-face: é a fonte do sistema`,
                );
            } else if (!fonts.isBodyFontLoaded) {
                fails.push(
                    `a fonte do body ("${fonts.bodyFamily}") não carregou`,
                );
            }

            const status = statusOf(fails, warnings);

            results.push(
                createResult(item, name, status, [...fails, ...warnings]),
            );

            await page.close();
        }
    } finally {
        await browser.close();
    }

    return results;
}
