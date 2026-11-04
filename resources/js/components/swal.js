let sweetAlertPromise;

function loadSweetAlert() {
    // ESM build without the bundled CSS: the styles come from `vendors/_vendors.scss`
    sweetAlertPromise ??= import("sweetalert2/dist/sweetalert2.esm.js").then(
        ({ default: Swal }) => {
            window.Swal = Swal;

            return Swal;
        },
    );

    return sweetAlertPromise;
}

/**
 * SweetAlert is only downloaded on the first call (ex.: Swal.fire(...)).
 * Until then, window.Swal is a proxy that loads the library and forwards the call.
 */
function setupSweetAlert() {
    return (window.Swal = new Proxy(
        {},
        {
            get:
                (target, method) =>
                (...args) =>
                    loadSweetAlert().then((Swal) => Swal[method](...args)),
        },
    ));
}

(() => {
    setupSweetAlert();
})();
