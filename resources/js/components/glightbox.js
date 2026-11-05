import { loadPlyr } from "/resources/js/components/plyr.js";

// Same providers GLightbox opens with Plyr (youtube, vimeo, local video files)
const videoLink =
    /youtube\.com|youtu\.be|youtube-nocookie\.com|vimeo\.com|\.(mp4|webm|ogv|mov)([?#]|$)/i;

/**
 * GLightbox is only downloaded when the page has a `.glightbox` item, together with the project theme.
 * Galleries with videos also load the project Plyr first: GLightbox only skips cdn.plyr.io
 * when window.Plyr already exists as the video slide loads.
 */
async function setupGLightBox() {
    const items = [...document.querySelectorAll(".glightbox")];

    if (!items.length) {
        return;
    }

    const hasVideo = items.some(
        (item) =>
            item.dataset.type === "video" ||
            videoLink.test(item.getAttribute("href") ?? ""),
    );

    const [{ default: GLightbox }] = await Promise.all([
        import("glightbox"),
        import("/resources/scss/vendors/glightbox/glightbox.scss"),
        hasVideo && loadPlyr(),
    ]);

    return GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
    });
}

(() => {
    setupGLightBox();
})();
