/**
 * Privacy policy: the site links to a real page (not "#") that answers 200
 */
import { chromium } from "playwright";
import { createResult, openPage } from "./results.js";

const item = "Política de privacidade";

/**
 * Runs in the page: links whose text, title or aria-label matches the pattern
 */
function findLinksInPage({ source, flags }) {
    const pattern = new RegExp(source, flags);

    return [...document.querySelectorAll("a")]
        .filter((link) =>
            [
                link.textContent,
                link.title,
                link.getAttribute("aria-label"),
            ].some((text) => text && pattern.test(text)),
        )
        .map((link) => ({
            text: link.textContent.trim().replace(/\s+/g, " "),
            href: link.getAttribute("href") ?? "",
            url: link.href,
        }));
}

/**
 * The destination must answer 200 itself: a redirect fails too (e.g. /html/* goes to the home in
 * production), showing where it goes
 */
async function checkDestination(target, url) {
    let problem = null;

    try {
        const response = await fetch(url, { redirect: "manual" });

        await response.body?.cancel();

        if (response.status !== 200) {
            const location = response.headers.get("location");

            problem = `respondeu ${response.status}${location ? ` → ${location}` : ""}`;
        }
    } catch (error) {
        problem = `não respondeu (${error.cause?.code ?? error.message})`;
    }

    return createResult(
        item,
        target,
        problem ? "fail" : "pass",
        problem ? [problem] : [],
    );
}

export default async function checkPrivacy({
    pages,
    privacyPolicyUrl,
    privacyLinkText,
}) {
    if (privacyPolicyUrl) {
        return [await checkDestination(privacyPolicyUrl, privacyPolicyUrl)];
    }

    const browser = await chromium.launch();
    const linksByUrl = new Map();

    try {
        for (const { name, url } of pages) {
            const page = await browser.newPage();

            await openPage(page, url);

            const links = await page.evaluate(findLinksInPage, {
                source: privacyLinkText.source,
                flags: privacyLinkText.flags,
            });

            for (const link of links) {
                const key = `${link.text} → ${link.href}`;

                linksByUrl.set(key, {
                    ...link,
                    pages: [...(linksByUrl.get(key)?.pages ?? []), name],
                });
            }

            await page.close();
        }
    } finally {
        await browser.close();
    }

    if (linksByUrl.size === 0) {
        return [
            createResult(item, "links", "fail", [
                `nenhum link com o texto ${privacyLinkText} nas páginas. Adicione o link ou defina \`privacyPolicyUrl\` em checklist-frontend.js`,
            ]),
        ];
    }

    const results = [];

    for (const [key, { href, url, pages: linkPages }] of linksByUrl) {
        const target = `${key} (${linkPages.join(", ")})`;
        const isPlaceholder =
            href.trim() === "" ||
            href.startsWith("#") ||
            href.startsWith("javascript:");

        if (isPlaceholder) {
            results.push(
                createResult(item, target, "fail", [
                    "o link não aponta para uma página",
                ]),
            );
            continue;
        }

        results.push(await checkDestination(target, url));
    }

    return results;
}
