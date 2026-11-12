export function onChangeSelectLink() {
    // Switch page action when links are in a select
    // e.g. to do in html
    // <select class="form-control js-onchange">
    //   <option value=""
    //     selected>Link
    //   </option>
    //   <option class="" value="/html/index">Home</option>
    //   <option class="" value="/html/tema">FAQ</option>
    //</select>

    // Delegated: also works for selects added after the load (Livewire, infinite scroll)
    document.addEventListener("change", (event) => {
        const select = event.target.closest(".js-onchange");

        if (!select) {
            return;
        }

        window.location = select.value;
    });
}
