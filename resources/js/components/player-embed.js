import { createPlayer } from "/resources/js/components/vlite.js";

const players = [];

// Pauses the playing videos when clicking outside them
function pauseOnClickOutside(event) {
    players.forEach(({ player, container }) => {
        if (!container.contains(event.target)) {
            player.pause();
        }
    });
}

/**
 * Embedded video (x-frontend::glightbox.player-embed): the thumb gives way to the player on click.
 */
function setupPlayerEmbed() {
    document.querySelectorAll(".js-player-embed-link").forEach((ctaVideo) => {
        // once: a double click would build two players in the same container
        ctaVideo.addEventListener(
            "click",
            async (event) => {
                event.preventDefault();

                const container = ctaVideo.closest(
                    ".js-player-embed-container",
                );
                const thumb = container.querySelector("img");

                // The player takes the thumb's place: the box keeps the thumb's rounded corners
                if (thumb) {
                    container.style.borderRadius =
                        getComputedStyle(thumb).borderRadius;
                    container.style.overflow = "hidden";
                }

                const player = await createPlayer(
                    container,
                    ctaVideo.dataset.videoLink,
                );

                if (!player) {
                    return;
                }

                // The clicked link left the page: the keyboard focus goes on to the player
                player.elements.container.focus({ preventScroll: true });

                if (!players.length) {
                    document.addEventListener("click", pauseOnClickOutside);
                }

                players.push({ player, container });
            },
            { once: true },
        );
    });
}

(() => {
    setupPlayerEmbed();
})();
