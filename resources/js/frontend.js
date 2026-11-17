import { setupAnchorReloadPrevention } from "./components/anchor-prevention.js";
import { setupToast } from "./components/bootstrap-helpers.js";
import { setupClipboardJS } from "./components/clipboard.js";
import { setupColorMode } from "./components/color-mode.js";
import { setupFmdHeader } from "./components/fmd-header.js";
import { setupInfiniteScroll } from "./components/infinite-scroll.js";
import { onChangeSelectLink } from "./components/select-link.js";
import { setupShareAPI } from "./components/share.js";
import { setupSmoothScroll } from "./components/smooth-scroll.js";
import { setupDefaultSlider } from "./components/sliders/default.js";
import { setupWOWJS } from "./components/wow.js";
import { setupCepSearch, setupStateCityOptions } from "./helpers/address.js";
import { setupDataLayerEventClickButton } from "./helpers/data-layer.js";
import { initializeFormHelpers } from "./helpers/form-helpers.js";
import { preventInvalidFormSubmit } from "./helpers/form-validation.js";
import { setupInputMasks } from "./helpers/input-masks.js";
import { setupUtmHelpers } from "./helpers/utm-helper.js";

// Each helper acts only where its class is on the page.
// Popovers and tooltips need nothing here: Bootstrap 6 starts them by `data-bs-toggle`.
(() => {
    // =========================================================================================
    // ALWAYS ON: light helpers, delegated on the document (they also work on html added after
    // the load, like Livewire and infinite scroll)
    // =========================================================================================

    preventInvalidFormSubmit();

    setupSmoothScroll(); // a.js-scroll-top

    onChangeSelectLink(); // .js-onchange

    setupInputMasks(); // .js-mask-* (registered on alpine:init), cpf/cnpj validation

    initializeFormHelpers(); // .js-full-name, .js-cellphone-validate, .js-phone-validate, .js-custom-file-input

    setupToast(); // .js-button-toast

    setupShareAPI(); // .js-btn-share (the link-share component loads the polyfill)

    setupUtmHelpers();

    setupColorMode();

    // =========================================================================================
    // OPT-IN: uncomment what the project uses
    // =========================================================================================

    // setupDataLayerEventClickButton(); // .js-btn-data-layer

    // setupCepSearch(); // .js-zipcode (ViaCEP)

    // setupStateCityOptions(); // .js-state, .js-city (public/json/estados-cidades.json)

    // setupDefaultSlider(); // .js-slider (Swiper only downloads with the class on the page)

    // setupClipboardJS(); // .js-copy (the lib only downloads with the class on the page)

    // setupWOWJS(); // .wow (the lib only downloads with the class on the page)

    // Prevents the jump to the top on every a[href="#"] of the page
    // setupAnchorReloadPrevention();
})();

// After the load: the header reads the page and header sizes, which only settle once images and fonts load
window.addEventListener("load", () => {
    setupFmdHeader();

    setupInfiniteScroll(); // .infinite-scroll
});
