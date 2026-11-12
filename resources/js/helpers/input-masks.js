import mask from "@alpinejs/mask";
import { CpfCnpjValidators } from "./cpf-cnpj-validators.js";

export function setupAlpine() {
    Alpine.plugin(mask);

    window.Alpine = Alpine;
}

export function setupInputMasks() {
    function setMaskToAllElements(elements, maskExpression) {
        elements.forEach((element) => {
            element.setAttribute("x-mask:dynamic", maskExpression);

            if (window.Alpine) {
                Alpine.initTree(element);
            }
        });
    }

    // PHONE (dynamic mask)
    setMaskToAllElements(
        document.querySelectorAll(".js-mask-phone"),
        "$input.length <= 14 ? '(99) 9999-9999' : '(99) 99999-9999'",
    );

    // CPF
    setMaskToAllElements(document.querySelectorAll(".js-mask-cpf"), () => {
        return "999.999.999-99";
    });

    // CNPJ
    setMaskToAllElements(document.querySelectorAll(".js-mask-cnpj"), () => {
        return "99.999.999/9999-99";
    });

    // CPF or CNPJ (dynamic)
    setMaskToAllElements(
        document.querySelectorAll(".js-mask-cpfcnpj"),
        "$input.replace(/\\D/g,'').length <= 11 ? '999.999.999-99' : '99.999.999/9999-99'",
    );

    // RG
    setMaskToAllElements(
        document.querySelectorAll(".js-mask-rg"),
        "$input.endsWith('x') ? '99.999.999-x' : ($input.endsWith('X') ? '99.999.999-X' : '99.999.999-9')",
    );

    // CEP
    setMaskToAllElements(document.querySelectorAll(".js-mask-cep"), () => {
        return "99999-999";
    });

    setMaskToAllElements(
        document.querySelectorAll(".js-mask-money"),
        "'R$ ' + $money($input, ',')",
    );

    // DATE
    setMaskToAllElements(document.querySelectorAll(".js-mask-date"), () => {
        return "99/99/9999";
    });

    const cpfCnpjValidators = new CpfCnpjValidators();
    const cpfInput = document.querySelector(cpfCnpjValidators.selectors.cpf);
    const cnpjInput = document.querySelector(cpfCnpjValidators.selectors.cnpj);

    if (cpfInput) {
        cpfInput.addEventListener("blur", function (event) {
            cpfCnpjValidators.checkCPF(event.target);
        });
    }

    if (cnpjInput) {
        cnpjInput.addEventListener("blur", function (event) {
            cpfCnpjValidators.checkCNPJ(event.target);
        });
    }
}
