export function setupAnchorReloadPrevention() {
    const targetClickLinkElements = document.querySelectorAll('a[href="#"]');

    targetClickLinkElements.forEach(function (linkElement) {
        linkElement.addEventListener("click", function (clickEvent) {
            clickEvent.preventDefault();
        });
    });
}
