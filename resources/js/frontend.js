import { setupAnchorReloadPrevention } from "./components/anchor-prevention.js";
import { setupPopover, setupTooltip } from "./components/bootstrap-helpers.js";
import { setupClipboardJS } from "./components/clipboard.js";
import { setupColorMode } from "./components/color-mode.js";
import { setupFmdHeader } from "./components/fmd-header.js";
import { setupInfiniteScroll } from "./components/infinite-scroll.js";
import { onChangeSelectLink } from "./components/select-link.js";
import { setupShareAPI } from "./components/share.js";
import { setupSmoothScroll } from "./components/smooth-scroll.js";
import { setupWOWJS } from "./components/wow.js";
import { setupCepSearch, setupStateCityOptions } from "./helpers/address.js";
import { initializeFormHelpers } from "./helpers/form-helpers.js";
import { preventInvalidFormSubmit } from "./helpers/form-validation.js";
import { setupAlpine, setupInputMasks } from "./helpers/input-masks.js";
import { setupUtmHelpers } from "./helpers/utm-helper.js";

(() => {
    preventInvalidFormSubmit();

    setupSmoothScroll();

    // setupCepSearch();

    // setupStateCityOptions();

    onChangeSelectLink();

    setupAlpine();

    setupInputMasks();

    // setupPopover();

    // setupTooltip();

    // setupAnchorReloadPrevention();

    initializeFormHelpers();

    // setupDefaultSlider();

    // setupClipboardJS();

    // setupShareAPI();

    // setupDataLayerEventClickButton();

    setupUtmHelpers();

    // setupWOWJS();

    setupColorMode();
})();

window.addEventListener("load", () => {
    /**
     * Usually the header triggers after the first section which has the
     * height defined as 100vh. We need the starting function here because
     * vh/vw are calculated after all resources loaded*/
    setupFmdHeader();

    setupInfiniteScroll();
});
