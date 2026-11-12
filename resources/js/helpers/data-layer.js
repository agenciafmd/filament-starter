/**
 * Data Layer type definition
 * @typedef {Object[]} window.dataLayer
 * */

/**
 * Data Layer Event type definition
 * @typedef {Object} DataLayerEvent
 * @property {string} event - The name of the event, typically gaEvent.
 * @property {string} category - The name of the category of event.
 * @property {string} action - The name of the action of event.
 * @property {string} label - The name of the label of event.
 * */

export function setupDataLayerEventClickButton() {
    // Delegated: also works for buttons added after the load (Livewire, infinite scroll)
    document.addEventListener("click", (clickEvent) => {
        const button = clickEvent.target.closest(".js-btn-data-layer");

        if (!button) {
            return;
        }

        const nameDataLayerAction = "data-fmd-datalayer-action";
        const linkDataLayerAction = button.getAttribute(nameDataLayerAction);

        if (!linkDataLayerAction) {
            throw new Error(
                `Adicione atributo ${nameDataLayerAction} com seu valor`,
            );
        }

        const dataLayerClickEvent = generateDataLayerEvent({
            action: linkDataLayerAction,
        });
        updateDataLayer(dataLayerClickEvent);
    });
}

/**
 * Generate Data Layer Event
 * @param {DataLayerEvent} options - Data Layer event options
 * @return {DataLayerEvent} - The new (or udpated) Data Layer event options
 * */
function generateDataLayerEvent(options) {
    return {
        ...options,
        event: options.event || "gaEvent",
        category: options.category || "clique",
        action: options.action || "",
        label: options.label || "enviado",
    };
}

/**
 * Pass an object to update Data Layer
 * @param {DataLayerEvent} dataToBePushed
 * */
function updateDataLayer(dataToBePushed) {
    // GTM replaces `push` on the original array: recreating it would hide the event from GTM
    (window.dataLayer ??= []).push(dataToBePushed);
}
