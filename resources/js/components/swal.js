let sweetAlertPromise;

function loadSweetAlert() {
    sweetAlertPromise ??= import("sweetalert2").then(({ default: Swal }) => {
        window.Swal = Swal;

        return Swal;
    });

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
