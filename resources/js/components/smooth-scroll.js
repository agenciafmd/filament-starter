function doScrollAnimate(targetSelector) {
    const target = document.querySelector(targetSelector);

    if (!target) {
        console.error(
            `Alvo não encontrado, verifique se existe um elemento na página com o seletor ${targetSelector}. Dê preferência a um ID, para evitar conflito no scroll.`,
        );
        return;
    }

    // data-scroll-offset moves the stop point: negative leaves more room above the target, positive scrolls further
    const extraOffset = Number(target.dataset.scrollOffset) || 0;

    target.style.scrollMarginTop = extraOffset
        ? `calc(var(--header-height) + ${-extraOffset}px)`
        : "";

    // No behavior: the root's scroll-behavior (Bootstrap reboot) animates it, except with prefers-reduced-motion.
    // The header is discounted by the global scroll-margin-top (_fmd-header.scss)
    target.scrollIntoView();
}

export function setupSmoothScroll() {
    document.querySelectorAll("a.js-scroll-top").forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault();

            // An open drawer (mobile) blocks the page scroll: scrolls after it closes (the link needs
            // data-bs-dismiss="drawer"). On desktop the navbar drawer is not open, so it scrolls right away
            const openDrawer = link.closest("dialog.drawer[open]");

            if (openDrawer) {
                openDrawer.addEventListener(
                    "hidden.bs.drawer",
                    () => doScrollAnimate(link.hash),
                    { once: true },
                );

                return;
            }

            doScrollAnimate(link.hash);
        });
    });
}
