export async function setupWOWJS() {
    if (!document.querySelector(".wow")) {
        return;
    }

    const { default: WOW } = await import("wow.js");

    new WOW().init();
}
