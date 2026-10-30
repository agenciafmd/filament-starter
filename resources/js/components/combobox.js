// Bootstrap 6 combobox creates its own hidden input and does not dispatch DOM events on it.
// The markup renders its own `<input type="hidden" data-combobox-input>` (with `name`/`wire:model`) inside the
// `.combobox` wrapper; it is kept in sync here, so forms and Livewire receive the selected value.
function setupCombobox() {
    document.addEventListener("change.bs.combobox", (event) => {
        const input = event.target
            .closest(".combobox")
            ?.querySelector("[data-combobox-input]");

        if (!input) {
            return;
        }

        input.value = Array.isArray(event.value)
            ? event.value.join(",")
            : (event.value ?? "");
        input.dispatchEvent(new Event("input", { bubbles: true }));
        input.dispatchEvent(new Event("change", { bubbles: true }));
    });
}

(() => {
    setupCombobox();
})();
