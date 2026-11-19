import { Modal, Popover, Toast, Tooltip } from "bootstrap";

// Bootstrap 5 does not start popovers and tooltips by the data API: these two start them all up front
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

export function setupModalConfig() {
    const modalElements = document.querySelectorAll(".modal");

    modalElements.forEach((modalElement) => {
        return new Modal(modalElement, {
            focus: false,
        });
    });
}
