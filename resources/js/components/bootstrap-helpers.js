import Popover from "bootstrap/js/dist/popover.js";
import Toast from "bootstrap/js/dist/toast.js";
import Tooltip from "bootstrap/js/dist/tooltip.js";

// Bootstrap 6 already starts popovers and tooltips by the data API (`data-bs-toggle`, delegated on the
// document): these two are only for starting them all up front
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
    // Delegated: also works for buttons added after the load (Livewire, infinite scroll)
    document.addEventListener("click", (event) => {
        const toastTriggerEl = event.target.closest(".js-button-toast");

        if (!toastTriggerEl) {
            return;
        }

        Toast.getOrCreateInstance(
            toastTriggerEl.nextElementSibling.querySelector(".toast"),
        ).show();
    });
}
