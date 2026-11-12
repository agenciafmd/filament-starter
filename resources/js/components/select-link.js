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

    const selects = document.querySelectorAll(".js-onchange");

    selects.forEach((select) => {
        select.addEventListener("change", function () {
            window.location = select.value;
        });
    });
}
