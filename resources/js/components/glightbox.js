async function setupGLightBox() {
    if (!document.querySelector(".glightbox")) {
        return;
    }

    const { default: GLightbox } = await import("glightbox");

    return GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
    });
}

(() => {
    setupGLightBox();
})();
