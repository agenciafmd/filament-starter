import playIcon from "/resources/svg/ic-ui-play.svg?raw";

/**
 * Project video player (vLitejs), shared by the embedded video (x-frontend::glightbox.player-embed)
 * and the video slides of the GLightbox gallery: same options and theme everywhere.
 * The library, its theme and the provider are only downloaded when a video is opened.
 */
const defaultOptions = {
    autoHide: true,
    playsinline: true,
};

const providers = {
    youtube: () => import("vlitejs/providers/youtube.js"),
    vimeo: () => import("vlitejs/providers/vimeo.js"),
};

const registeredProviders = new Map();

let playerCount = 0;

/**
 * The player's iframe never takes the focus on purpose (vLitejs sets pointer-events: none on it),
 * but the Vimeo player focuses its own iframe when it plays: from then on the keys stay inside the
 * iframe and never reach the page (ex.: the arrows and Esc of the GLightbox gallery).
 * The focus goes back to the player's container, which vLitejs makes focusable.
 */
window.addEventListener("blur", () => {
    setTimeout(() => {
        const player = document.activeElement?.matches("iframe")
            ? document.activeElement.closest(".v-vlite")
            : null;

        player?.querySelector(".v-container")?.focus({ preventScroll: true });
    });
});

/**
 * Reads the provider and the video id out of a YouTube, Vimeo or video file link.
 *
 * @param {string} link
 * @returns {{provider: string, id: string}|null}
 */
export function videoSource(link) {
    const youtube = link.match(
        /(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:embed\/|shorts\/|live\/|v\/|watch\?(?:.*&)?v=))([\w-]{11})/i,
    );

    if (youtube) {
        return { provider: "youtube", id: youtube[1] };
    }

    const vimeo = link.match(/vimeo\.com\/(?:.*\/)?(\d+)/i);

    if (vimeo) {
        return { provider: "vimeo", id: vimeo[1] };
    }

    if (/\.(mp4|webm|ogv|mov)([?#]|$)/i.test(link)) {
        return { provider: "html5", id: link };
    }

    return null;
}

async function loadVlite(provider) {
    const [{ default: Vlitejs }] = await Promise.all([
        import("vlitejs"),
        import("/resources/scss/vendors/vlite/vlite.scss"),
    ]);

    // registerProvider throws when the same provider is registered twice, and GLightbox loads
    // the next slide together with the current one: every call waits on the same registration
    if (providers[provider] && !registeredProviders.has(provider)) {
        registeredProviders.set(
            provider,
            providers[provider]().then(({ default: Provider }) =>
                Vlitejs.registerProvider(provider, Provider),
            ),
        );
    }

    await registeredProviders.get(provider);

    return Vlitejs;
}

/**
 * Builds the player inside the container (with the DOM API: the link comes from the admin
 * and is never parsed as html) and starts it. Resolves with the player once it's ready.
 *
 * @param {HTMLElement} container
 * @param {string} link
 * @param {{play?: boolean}} options `play: false` builds the player without starting it; the rest are vLitejs options
 * @returns {Promise<object|null>}
 */
export async function createPlayer(
    container,
    link,
    { play = true, ...options } = {},
) {
    const source = videoSource(link);

    if (!source) {
        return null;
    }

    const Vlitejs = await loadVlite(source.provider);

    let element;

    if (source.provider === "html5") {
        element = document.createElement("video");
        element.src = source.id;
    } else {
        element = document.createElement("div");
        element.dataset[`${source.provider}Id`] = source.id;
    }

    // The YouTube API looks the player up by id
    element.id = `vlite-${++playerCount}`;
    container.replaceChildren(element);

    return new Promise((resolve) => {
        new Vlitejs(element, {
            provider: source.provider,
            options: { ...defaultOptions, ...options },
            // The click that opened the video is the user gesture: plays with sound
            // (the `autoplay` option would mute it)
            onReady: (player) => {
                // Same play icon as the thumbs (.ic-play); the button stays hidden while loading
                const bigPlay =
                    player.elements.container.querySelector(".v-bigPlay");

                if (bigPlay) {
                    bigPlay.innerHTML = playIcon;
                }

                if (play) {
                    player.play();
                }

                resolve(player);
            },
        });
    });
}
