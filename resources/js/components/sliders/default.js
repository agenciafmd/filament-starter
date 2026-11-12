export async function setupDefaultSlider() {
    const defaultSliderSelector = ".js-slider";

    if (!document.querySelector(defaultSliderSelector)) {
        return;
    }

    // Swiper only downloads on pages with the slider
    const { createSlider } = await import("../swiper.js");

    document
        .querySelectorAll(defaultSliderSelector)
        .forEach(function createDefaultSlider(defaultSliderContainerElement) {
            createSlider({
                container: defaultSliderContainerElement,
                navigation: {
                    prevEl: `${defaultSliderSelector} .swiper-button-prev`,
                    nextEl: `${defaultSliderSelector} .swiper-button-next`,
                },
            });
        });
}
