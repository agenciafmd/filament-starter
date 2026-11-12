import { guideUserToTheFirstError } from "./form-helpers.js";

export function preventInvalidFormSubmit() {
    const forms = document.querySelectorAll(".needs-validation");

    forms.forEach((form) => {
        form.addEventListener(
            "submit",
            function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();

                    guideUserToTheFirstError(form);
                    form.classList.add("was-validated");
                    // Bootstrap 6 styles the invalid fields (`:user-invalid`) only inside `[data-bs-validate]`
                    form.dataset.bsValidate = "";
                }
            },
            false,
        );
    });

    setupInvalidElements();

    function setupInvalidElements() {
        const invalidElements = document.querySelectorAll(".is-invalid");

        invalidElements.forEach((element) => {
            element.setCustomValidity("needs validate");

            element.addEventListener("focusout", () => {
                element.classList.remove("is-invalid");
                element.setCustomValidity("");
            });
        });
    }
}
