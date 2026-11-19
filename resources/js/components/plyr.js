/**
 * Plyr is only downloaded when a video is opened, together with the project theme.
 * Exposed on window.Plyr so other components (ex.: the glightbox gallery) reuse it instead of the CDN.
 */
export async function loadPlyr() {
    const [{ default: Plyr }] = await Promise.all([
        import("plyr"),
        import("/resources/scss/vendors/plyr/plyr.scss"),
    ]);

    return (window.Plyr = Plyr);
}

async function setupPlyr() {
    const playerEmbeds = document.querySelectorAll(".js-player-embed");

    if (!playerEmbeds.length) {
        return;
    }

    const Plyr = await loadPlyr();

    const players = [...playerEmbeds].map(
        (player) =>
            new Plyr(player, {
                autoplay: true,
                quality: 1080,
                settings: ["captions", "quality", "speed", "loop"],
            }),
    );

    // Pauses the players when clicking outside them
    document.addEventListener("click", (event) => {
        players.forEach((player) => {
            if (
                !player.elements.container.contains(event.target) &&
                !player.paused
            ) {
                player.pause();
            }
        });
    });
}

function setupEmbedVideo() {
    const ctaVideos = document.querySelectorAll(".js-player-embed-link");

    if (!ctaVideos.length) {
        return;
    }

    ctaVideos.forEach((ctaVideo) => {
        ctaVideo.addEventListener("click", (event) => {
            event.preventDefault();

            // Built with the DOM API: the embed id comes from the admin and is never parsed as html
            const player = document.createElement("div");

            player.id = ctaVideo.id;
            player.className = "js-player-embed";
            player.dataset.plyrProvider = ctaVideo.dataset.plyrProvider;
            player.dataset.plyrEmbedId = ctaVideo.dataset.plyrEmbedId;

            ctaVideo
                .closest(".js-player-embed-container")
                .replaceChildren(player);

            setupPlyr();
        });
    });
}

(() => {
    setupEmbedVideo();
})();
