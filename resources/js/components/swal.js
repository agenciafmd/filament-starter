/**
 * SweetAlert2 is only downloaded on the first call (ex.: Swal.fire(...)), together with the project theme.
 * Until then, window.Swal is a proxy that loads the library and forwards the call.
 */
async function loadSweetAlert() {
    const [{ default: Swal }] = await Promise.all([
        import("sweetalert2/dist/sweetalert2.esm.js"),
        import("/resources/scss/vendors/sweetalert2/sweetalert2.scss"),
    ]);

    return (window.Swal = Swal);
}

window.Swal = new Proxy(
    {},
    {
        get:
            (target, method) =>
            async (...args) =>
                (await loadSweetAlert())[method](...args),
    },
);
