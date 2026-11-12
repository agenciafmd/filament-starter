export function setupShareAPI() {
    const shareButtonElements = document.querySelectorAll(".js-btn-share");

    if (!shareButtonElements.length) {
        return;
    }

    const pageTitle = document.querySelector("title").textContent;
    const pageDescription = document
        .querySelector('meta[name="description"]')
        .getAttribute("content");

    shareButtonElements.forEach((buttonItem) => {
        buttonItem.addEventListener("click", (e) => {
            e.preventDefault();

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
    });
}
