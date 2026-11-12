import mask from "@alpinejs/mask";
import { CpfCnpjValidators } from "./cpf-cnpj-validators.js";

// Class of the field → x-mask:dynamic expression (@alpinejs/mask)
const masks = {
    ".js-mask-phone":
        "$input.length <= 14 ? '(99) 9999-9999' : '(99) 99999-9999'",
    ".js-mask-cpf": "'999.999.999-99'",
    ".js-mask-cnpj": "'99.999.999/9999-99'",
    ".js-mask-cpfcnpj":
        "$input.replace(/\\D/g,'').length <= 11 ? '999.999.999-99' : '99.999.999/9999-99'",
    ".js-mask-rg":
        "$input.endsWith('x') ? '99.999.999-x' : ($input.endsWith('X') ? '99.999.999-X' : '99.999.999-9')",
    ".js-mask-cep": "'99999-999'",
    ".js-mask-money": "'R$ ' + $money($input, ',')",
    ".js-mask-date": "'99/99/9999'",
};

function setMaskAttribute(element) {
    if (element.hasAttribute("x-mask:dynamic")) {
        return;
    }

    const selector = Object.keys(masks).find((maskSelector) =>
        element.matches(maskSelector),
    );

    if (selector) {
        element.setAttribute("x-mask:dynamic", masks[selector]);
    }
}

export function setupInputMasks() {
    // Alpine comes from <livewire:scripts /> and fires alpine:init when it starts: without it, no mask and no error
    document.addEventListener("alpine:init", () => {
        window.Alpine.plugin(mask);

        // Alpine only walks its components on start: also walk the masked fields outside them
        window.Alpine.addInitSelector(() => Object.keys(masks).join(", "));

        // Runs before the directives of every element Alpine inits, also the ones added later (Alpine watches the DOM)
        window.Alpine.interceptInit(setMaskAttribute);
    });

    // A Livewire re-render (morph) drops the attribute the server html does not have: puts it back
    document.addEventListener("livewire:init", () => {
        window.Livewire.hook("morph.updated", ({ el }) => {
            if (el instanceof Element) {
                setMaskAttribute(el);
            }
        });
    });

    const cpfCnpjValidators = new CpfCnpjValidators();

    // Delegated: validates every cpf/cnpj field, also the ones added after the load (Livewire)
    document.addEventListener("focusout", (event) => {
        if (event.target.closest(cpfCnpjValidators.selectors.cpf)) {
            cpfCnpjValidators.checkCPF(event.target);
        }

        if (event.target.closest(cpfCnpjValidators.selectors.cnpj)) {
            cpfCnpjValidators.checkCNPJ(event.target);
        }
    });
}
