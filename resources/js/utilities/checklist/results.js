/**
 * Shared helpers of the frontend checklist (checklist-frontend.js)
 */

// Time (ms) the page's JS gets to run (slider, header, lazy css) before it's checked
const waitForJsTime = 500;

/**
 * One line of the checklist: item ("Fontes"), target (page or file), status and details
 *
 * @param {"pass"|"warn"|"fail"} status
 */
export function createResult(item, target, status, details = [], extra = {}) {
    return { item, target, status, details, ...extra };
}

/**
 * fail when there's a failure, warn when there's only warnings, pass otherwise
 */
export function statusOf(fails, warnings = []) {
    if (fails.length > 0) {
        return "fail";
    }

    return warnings.length > 0 ? "warn" : "pass";
}

/**
 * Opens the url and waits for the load plus the page's JS
 */
export async function openPage(page, url) {
    await page.goto(url, { waitUntil: "load" });
    await page.waitForTimeout(waitForJsTime);
}
