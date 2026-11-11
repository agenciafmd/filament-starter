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
    // The links inside a drawer are left to setupSmoothScrollInDrawer: the drawer animation
    // blocks the page scroll, so they scroll only after it closes
    const scrollTriggerElements = document.querySelectorAll(
        "a.js-scroll-top:not(.drawer a)",
    );

    scrollTriggerElements.forEach(function (element) {
        element.addEventListener("click", function (event) {
            event.preventDefault();
            doScrollAnimate(this.hash);
        });
    });
}
