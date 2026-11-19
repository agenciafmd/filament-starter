/**
 * Lighthouse: performance, accessibility, best practices and SEO of each page, in Playwright's
 * Chromium (mobile, the Lighthouse default). The html report of each page goes to the report folder
 */
import { writeFile, mkdir } from "fs/promises";
import lighthouse from "lighthouse";
import { chromium } from "playwright";
import { createResult, statusOf } from "./results.js";

const item = "Lighthouse";

const debuggingPort = 9333;

const categoryLabels = {
    performance: "Performance",
    accessibility: "Acessibilidade",
    "best-practices": "Boas práticas",
    seo: "SEO",
};

export default async function checkLighthouse({
    pages,
    reportFolder,
    lighthouseThresholds,
    performanceFailsBelowThreshold,
}) {
    const browser = await chromium.launch({
        args: [`--remote-debugging-port=${debuggingPort}`],
    });
    const lighthouseFolder = `${reportFolder}/lighthouse`;
    const results = [];

    await mkdir(lighthouseFolder, { recursive: true });

    try {
        for (const { name, url } of pages) {
            const { lhr, report } = await lighthouse(url, {
                port: debuggingPort,
                output: "html",
                logLevel: "error",
                onlyCategories: Object.keys(lighthouseThresholds),
            });

            const file = `lighthouse/${name.replace(/[^\w-]/g, "_") || "index"}.html`;

            await writeFile(`${reportFolder}/${file}`, report);

            const scores = {};
            const fails = [];
            const warnings = [];

            for (const [category, minimum] of Object.entries(
                lighthouseThresholds,
            )) {
                const score = Math.round(
                    (lhr.categories[category]?.score ?? 0) * 100,
                );

                scores[category] = score;

                if (score >= minimum) {
                    continue;
                }

                const message = `${categoryLabels[category]}: ${score} (mínimo ${minimum})`;
                const isWarning =
                    category === "performance" &&
                    !performanceFailsBelowThreshold;

                (isWarning ? warnings : fails).push(
                    isWarning
                        ? `${message}. Local, sem compressão: confira em produção`
                        : message,
                );
            }

            const summary = Object.entries(scores)
                .map(
                    ([category, score]) =>
                        `${categoryLabels[category]} ${score}`,
                )
                .join(" · ");

            const status = statusOf(fails, warnings);

            results.push(
                createResult(
                    item,
                    `${name} (${summary})`,
                    status,
                    [...fails, ...warnings],
                    {
                        report: file,
                        scores,
                    },
                ),
            );
        }
    } finally {
        await browser.close();
    }

    return results;
}
