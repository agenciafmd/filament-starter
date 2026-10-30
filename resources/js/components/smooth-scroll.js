function doScrollAnimate(targetSelector) {
    const target = document.querySelector(targetSelector);

    if (!target) {
        console.error(
            `Alvo não encontrado, verifique se existe um elemento na página com o seletor ${targetSelector}. Dê preferência a um ID, para evitar conflito no scroll.`,
        );
        return;
    }

    const additionalOffset =
        Number(target.getAttribute("data-scroll-offset")) || 0;

    const scrollTop =
        target.getBoundingClientRect().top +
        document.body.scrollTop +
        additionalOffset;

    window.scrollBy({
        top: scrollTop,
        behavior: "smooth",
    });
}

export function setupSmoothScrollInDrawer() {
    const drawerElements = document.querySelectorAll(".drawer");

    drawerElements.forEach(function (drawer) {
        const drawerScrollTriggerElements = drawer.querySelectorAll(
            'a.js-scroll-top[data-bs-dismiss="drawer"]',
        );

        drawerScrollTriggerElements.forEach(function (triggerElement) {
            const hiddenOffcanvasHandler = (event) => {
                doScrollAnimate(triggerElement.hash);
                drawer.removeEventListener(
                    "hidden.bs.drawer",
                    hiddenOffcanvasHandler,
                );
            };

            triggerElement.addEventListener("click", function (event) {
                event.preventDefault();
                drawer.addEventListener(
                    "hidden.bs.drawer",
                    hiddenOffcanvasHandler,
                );
            });
        });
    });
}

export function setupSmoothScroll() {
    // This selector is needed because drawer animation blocks page scroll, so
    // we need to handle each scroll separately.
    const scrollTriggerElements = document.querySelectorAll(
        "*:not(.drawer) a.js-scroll-top",
    );

    scrollTriggerElements.forEach(function (element) {
        element.addEventListener("click", function (event) {
            event.preventDefault();
            doScrollAnimate(this.hash);
        });
    });
}
