import { createPlayer, videoSource } from "/resources/js/components/vlite.js";

/**
 * Turns the video items into inline slides played by the project player (resources/js/components/vlite.js):
 * the GLightbox video slide only works with Plyr, which the project no longer uses. The href stays the video link, so without JS it still opens the video.
 *
 * @param {HTMLElement[]} items
 * @returns {boolean} whether the gallery has any video
 */
function prepareVideoItems(items) {
    const videos = items.filter((item) =>
        videoSource(item.getAttribute("href") ?? ""),
    );

    videos.forEach((item) => {
        // The slide keeps the link's .ratio classes (aspectRatio prop of x-frontend::glightbox.video), 16x9 by default.
        // Static markup: only "ratio-*" class names get in, never the link (it comes from the admin and is read from the trigger's href)
        const ratio =
            [...item.classList]
                .filter((name) => /^ratio(-\w+)*$/.test(name))
                .join(" ") || "ratio ratio-16x9";

        delete item.dataset.type;
        item.dataset.content = `<div class="${ratio} js-vlite-slide"></div>`;
        // GLightbox reads any href without "#" as the id of an inline element and drops the slide
        item.dataset.href = "";
        item.dataset.width ??= "960px";
        item.dataset.height ??= "auto";
    });

    return videos.length > 0;
}

/**
 * Plays the video of each slide with the project player. GLightbox also loads the slides around
 * the current one: those get the player without starting it, and play once they become the current slide.
 * The slide that is left is paused and every player is destroyed when the gallery closes.
 */
function setupVideoSlides(lightbox) {
    // Keyed by the slide index: GLightbox's slide_changed may carry a stale slideNode
    const players = new Map();

    const withPlayer = (index, callback) =>
        players.get(index)?.then((player) => player && callback(player));

    lightbox.on("slide_after_load", ({ slideNode, slideIndex, trigger }) => {
        const container = slideNode.querySelector(".js-vlite-slide");

        if (container) {
            players.set(
                slideIndex,
                // A failed download (network, ad blocker) leaves the slide empty, without errors on every slide change
                createPlayer(container, trigger.getAttribute("href"), {
                    play: slideIndex === lightbox.index,
                }).catch(() => null),
            );
        }
    });

    lightbox.on("slide_before_change", ({ prev }) => {
        withPlayer(prev.index, (player) => player.pause());
    });

    lightbox.on("slide_changed", ({ current }) => {
        withPlayer(current.index, (player) => player.play());
    });

    lightbox.on("close", () => {
        players.forEach((player) =>
            player.then((instance) => instance?.destroy()),
        );
        players.clear();
    });
}

/**
 * GLightbox is only downloaded when the page has a `.glightbox` item, together with the project theme.
 */
async function setupGLightBox() {
    const items = [...document.querySelectorAll(".glightbox")];

    if (!items.length) {
        return;
    }

    const hasVideo = prepareVideoItems(items);

    const [{ default: GLightbox }] = await Promise.all([
        import("glightbox"),
        import("/resources/scss/vendors/glightbox/glightbox.scss"),
    ]);

    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
    });

    // With a single item the loop sends the arrows, the keyboard and the swipe back to the same slide:
    // GLightbox animates it in again and the video restarts
    const loop = lightbox.loop.bind(lightbox);
    lightbox.loop = () => lightbox.elements.length > 1 && loop();

    if (hasVideo) {
        setupVideoSlides(lightbox);
    }

    return lightbox;
}

(() => {
    setupGLightBox();
})();
