// Theme toggle (light/dark)
// The initial theme is applied in the <head> by `<x-frontend::color-mode />` (saved choice or OS preference).
// The button saves the choice; without a saved choice, the page follows OS changes.
const STORAGE_KEY = "theme";
const TOGGLE_SELECTOR = ".js-color-mode-toggle";

function getStoredTheme() {
    try {
        return localStorage.getItem(STORAGE_KEY);
    } catch {
        return null;
    }
}

function storeTheme(theme) {
    try {
        localStorage.setItem(STORAGE_KEY, theme);
    } catch {
        // Storage blocked (private mode): the choice lasts only for this page
    }
}

function getSystemTheme() {
    return window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light";
}

function updateToggles(theme) {
    const isDark = theme === "dark";

    document.querySelectorAll(TOGGLE_SELECTOR).forEach((toggle) => {
        toggle.setAttribute("aria-pressed", String(isDark));
        toggle.setAttribute(
            "aria-label",
            isDark ? "Ativar tema claro" : "Ativar tema escuro",
        );
    });
}

// Switches the theme with the transitions off: components with `transition: all` (navbar, links)
// would fade to the new colors after the page, and the header would flash
function applyTheme(theme) {
    const disableTransitions = document.createElement("style");
    disableTransitions.textContent =
        "*,*::before,*::after{transition:none!important}";
    document.head.appendChild(disableTransitions);

    document.documentElement.setAttribute("data-bs-theme", theme);
    updateToggles(theme);

    // Force the new styles to be applied before the transitions come back
    window.getComputedStyle(document.body).backgroundColor;
    requestAnimationFrame(() => {
        requestAnimationFrame(() => disableTransitions.remove());
    });
}

export function setupColorMode() {
    const currentTheme =
        document.documentElement.getAttribute("data-bs-theme") ??
        getSystemTheme();

    updateToggles(currentTheme);

    document.querySelectorAll(TOGGLE_SELECTOR).forEach((toggle) => {
        toggle.addEventListener("click", () => {
            const theme =
                document.documentElement.getAttribute("data-bs-theme") ===
                "dark"
                    ? "light"
                    : "dark";

            storeTheme(theme);
            applyTheme(theme);
        });
    });

    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", () => {
            const storedTheme = getStoredTheme();

            if (storedTheme !== "light" && storedTheme !== "dark") {
                applyTheme(getSystemTheme());
            }
        });
}
