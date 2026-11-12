import Popover from "bootstrap/js/dist/popover.js";
import Toast from "bootstrap/js/dist/toast.js";
import Tooltip from "bootstrap/js/dist/tooltip.js";

export function setupPopover() {
    const popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]'),
    );

    popoverTriggerList.map((popoverTriggerEl) => {
        return new Popover(popoverTriggerEl, {});
    });
}

export function setupTooltip() {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    );

    tooltipTriggerList.map((tooltipTriggerEl) => {
        return new Tooltip(tooltipTriggerEl);
    });
}

export function setupToast() {
    const toastTriggerList = [].slice.call(
        document.querySelectorAll(".js-button-toast"),
    );

    toastTriggerList.map((toastTriggerEl) => {
        return toastTriggerEl.addEventListener("click", () => {
            Toast.getOrCreateInstance(
                toastTriggerEl.nextElementSibling.querySelector(".toast"),
            ).show();
        });
    });
}
