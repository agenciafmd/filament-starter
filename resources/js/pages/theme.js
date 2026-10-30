import "share-api-polyfill";
// Bootstrap 6 plugins used only by the theme catalog (the site-wide ones are in frontend-imports.js)
import "bootstrap/js/dist/chips.js";
import "bootstrap/js/dist/datepicker.js";
import "bootstrap/js/dist/nav-overflow.js";
import "bootstrap/js/dist/otp-input.js";
import "bootstrap/js/dist/range.js";
import "bootstrap/js/dist/strength.js";
import "bootstrap/js/dist/toggler.js";

import {
    setupPopover,
    setupShareAPI,
    setupToast,
    setupTooltip,
} from "../frontend.js";

(function () {
    setupShareAPI();

    setupPopover();

    setupTooltip();

    setupToast();
})();
