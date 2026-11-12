export async function setupWOWJS() {
    const { default: WOW } = await import("wow.js");

    new WOW().init();
}
