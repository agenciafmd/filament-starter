export function setupShareAPI() {
    // Delegated: also works for buttons added after the load (Livewire, infinite scroll).
    // Desktop browsers need the polyfill: the link-share component loads it (components/share-api.js)
    document.addEventListener("click", (e) => {
        const buttonItem = e.target.closest(".js-btn-share");

        if (!buttonItem) {
            return;
        }

        e.preventDefault();

        const pageTitle = document.querySelector("title").textContent;
        const pageDescription = document
            .querySelector('meta[name="description"]')
            .getAttribute("content");

        navigator
            .share(
                {
                    title: pageTitle,
                    text: pageDescription,
                    url: location.href,
                    fbId: buttonItem.getAttribute(
                        "data-fmd-share-btn-fbidentification",
                    ),
                },
                {
                    // change this configurations to hide specific unnecessary icons
                    copy: true,
                    email: true,
                    print: true,
                    sms: true,
                    messenger: true,
                    facebook: true,
                    whatsapp: true,
                    twitter: true,
                    linkedin: true,
                    telegram: true,
                    skype: true,
                    language: "pt", // specify the default language
                },
            )
            .then(() => console.log("Compartilhado com sucesso!"))
            .catch((error) =>
                console.log("Ops! Algo de errado aconteceu:'(\n", error),
            );
    });
}
