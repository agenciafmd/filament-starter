import Tooltip from "bootstrap/js/dist/tooltip.js";

export async function setupClipboardJS() {
    // Don't forget to install the package: npm install clipboard --save

    if (!document.querySelector(".js-copy")) {
        return;
    }

    const { default: ClipboardJS } = await import("clipboard");

    const triggerElement = new ClipboardJS(".js-copy");

    triggerElement.on("success", (event) => {
        showTooltip(event.trigger);
    });

    function showTooltip(targetElement) {
        const successTooltip = Tooltip.getOrCreateInstance(targetElement, {
            title: "Copiado para a área de transferência",
            placement: "bottom",
            trigger: "manual",
        });

        successTooltip.show();

        setTimeout(() => {
            successTooltip.hide();
        }, 2000);
    }
}
