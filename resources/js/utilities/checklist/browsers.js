/**
 * Browsers and breakpoints: each page in each browser (Chromium, Firefox, WebKit) and viewport
 * (the breakpoints of utilities/critical.js)
 * - compatibility: no JS error and no same-origin request with 4xx/5xx;
 * - layout: no horizontal scroll, listing the elements that cross the right edge;
 * - a full page screenshot for the visual review, which stays manual.
 */
import { mkdir } from "fs/promises";
import { createResult, openPage } from "./results.js";

// Elements listed per overflow
const maxOverflowingElements = 5;

/**
 * Runs in the page: the horizontal overflow and the outermost elements that cause it
 */
function readOverflowInPage(maxElements) {
    const root = document.documentElement;
    const width = root.clientWidth;
    const overflow = root.scrollWidth - width;

    if (overflow <= 0) {
        return null;
    }

    // Elements inside a fixed or clipping ancestor don't scroll the page
    const isContained = (element) => {
        for (
            let parent = element.parentElement;
            parent && parent !== document.body;
            parent = parent.parentElement
        ) {
            const style = getComputedStyle(parent);

            if (style.position === "fixed" || style.overflowX !== "visible") {
                return true;
            }
        }

        return false;
    };

    const describe = (element) => {
        const id = element.id ? `#${element.id}` : "";
        const classes = [...element.classList]
            .slice(0, 3)
            .map((name) => `.${name}`)
            .join("");

        return `${element.tagName.toLowerCase()}${id}${classes}`;
    };

    const overflowing = [...document.body.querySelectorAll("*")].filter(
        (element) => {
            const rect = element.getBoundingClientRect();

            return (
                rect.width > 0 &&
                rect.right > width + 1 &&
                getComputedStyle(element).position !== "fixed" &&
                !isContained(element)
            );
        },
    );

    // Only the outermost: the children of an overflowing element overflow with it
    const outermost = overflowing.filter(
        (element) =>
            !overflowing.some(
                (other) => other !== element && other.contains(element),
            ),
    );

    if (outermost.length > 0) {
        return {
            overflow,
            elements: outermost
                .slice(0, maxElements)
                .map(
                    (element) =>
                        `${describe(element)} (borda direita em ${Math.round(element.getBoundingClientRect().right)}px)`,
                ),
        };
    }

    // A child moved by transform or left/right (e.g. width: 100vw + translateX(-50%)) looks inside
    // the screen, but its layout box still scrolls the page: list the deepest container it overflows
    const overflowingContainers = [
        ...document.body.querySelectorAll("*"),
    ].filter(
        (element) =>
            element.clientWidth > 0 &&
            element.scrollWidth > element.clientWidth + 1 &&
            getComputedStyle(element).overflowX === "visible" &&
            !isContained(element),
    );

    const deepest = overflowingContainers.filter(
        (element) =>
            !overflowingContainers.some(
                (other) => other !== element && element.contains(other),
            ),
    );

    return {
        overflow,
        elements: deepest
            .slice(0, maxElements)
            .map(
                (element) =>
                    `conteúdo de ${describe(element)} passa da borda (filho com transform, left/right ou 100vw?): ${[...element.children].map(describe).join(", ")}`,
            ),
    };
}

function isSameOrigin(url, baseUrl) {
    return new URL(url).origin === new URL(baseUrl).origin;
}

export default async function checkBrowsers({
    pages,
    browsers,
    viewports,
    baseUrl,
    reportFolder,
    ignoredConsoleErrors,
}) {
    const compatibilityResults = [];
    const layoutResults = [];
    const screenshotsFolder = `${reportFolder}/screenshots`;

    await mkdir(screenshotsFolder, { recursive: true });

    for (const { name: browserName, type } of browsers) {
        let browser;

        try {
            browser = await type.launch();
        } catch (error) {
            compatibilityResults.push(
                createResult("Navegadores", browserName, "fail", [
                    `não abriu: ${error.message.split("\n")[0]}`,
                    "faltam libs do sistema? vendor/bin/sail exec -u root laravel.test npx playwright install-deps",
                ]),
            );
            continue;
        }

        try {
            for (const { name: pageName, url } of pages) {
                const errors = new Set();
                const screenshots = [];
                const layoutProblems = [];

                for (const viewport of viewports) {
                    const page = await browser.newPage({ viewport });

                    page.on("pageerror", (error) =>
                        errors.add(`erro de JS: ${error.message}`),
                    );
                    page.on("console", (message) => {
                        const isIgnored = ignoredConsoleErrors.some((pattern) =>
                            pattern.test(message.text()),
                        );

                        if (message.type() === "error" && !isIgnored) {
                            errors.add(`console.error: ${message.text()}`);
                        }
                    });
                    page.on("response", (response) => {
                        if (
                            response.status() >= 400 &&
                            isSameOrigin(response.url(), baseUrl)
                        ) {
                            errors.add(
                                `${response.status()}: ${response.url()}`,
                            );
                        }
                    });

                    await openPage(page, url);

                    const overflow = await page.evaluate(
                        readOverflowInPage,
                        maxOverflowingElements,
                    );

                    if (overflow) {
                        layoutProblems.push(
                            `${viewport.width}px: rolagem horizontal de ${overflow.overflow}px`,
                            ...overflow.elements.map(
                                (element) => `   ${element}`,
                            ),
                        );
                    }

                    const file = `${pageName}-${browserName}-${viewport.width}.jpg`;

                    await page.screenshot({
                        path: `${screenshotsFolder}/${file}`,
                        fullPage: true,
                        type: "jpeg",
                        quality: 60,
                    });

                    screenshots.push({
                        file: `screenshots/${file}`,
                        width: viewport.width,
                        hasOverflow: !!overflow,
                    });

                    await page.close();
                }

                compatibilityResults.push(
                    createResult(
                        "Navegadores",
                        `${pageName} · ${browserName}`,
                        errors.size > 0 ? "fail" : "pass",
                        [...errors],
                    ),
                );

                layoutResults.push(
                    createResult(
                        "Breakpoints",
                        `${pageName} · ${browserName}`,
                        layoutProblems.length > 0 ? "fail" : "pass",
                        layoutProblems,
                        { screenshots },
                    ),
                );
            }
        } finally {
            await browser.close();
        }
    }

    return [...compatibilityResults, ...layoutResults];
}
