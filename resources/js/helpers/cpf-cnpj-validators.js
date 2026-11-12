import { setInvalidInput, setValidInput } from "./form-helpers.js";

export class CpfCnpjValidators {
    constructor() {
        this.sizes = {
            cpf: 11,
            cnpj: 14,
        };
        this.selectors = {
            cpf: ".js-mask-cpf",
            cnpj: ".js-mask-cnpj",
        };
    }

    sanitize(cpfOrCnpj) {
        return cpfOrCnpj.replace(/[^\d]+/g, "");
    }

    checkCNPJ(cnpjInput) {
        const sanitizedCnpj = this.sanitize(cnpjInput.value);

        const sizes = {
            full: sanitizedCnpj.length,
            prefix: sanitizedCnpj.length - 2,
        };

        const cnpj = {
            number: {
                full: sanitizedCnpj,
                prefix: sanitizedCnpj.substring(0, sizes.prefix),
                suffix: sanitizedCnpj.substring(sizes.prefix),
            },
        };

        if (!cnpj.number.full || cnpj.number.full.length !== this.sizes.cnpj) {
            setInvalidInput({ input: cnpjInput });
            return;
        }

        if (/^(\d)\1+$/.test(cnpj.number.full)) {
            setInvalidInput({ input: cnpjInput });
            return;
        }

        let sum = 0;
        let positionIndex = sizes.prefix - 7;

        for (let i = sizes.prefix; i >= 1; i--) {
            sum += cnpj.number.full.charAt(sizes.prefix - i) * positionIndex--;

            if (positionIndex < 2) {
                positionIndex = 9;
            }
        }

        let result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

        if (result !== Number(cnpj.number.suffix.charAt(0))) {
            setInvalidInput({ input: cnpjInput });
            return;
        }

        sizes.prefix = sizes.prefix + 1;
        sum = 0;
        positionIndex = sizes.prefix - 7;

        for (let i = sizes.prefix; i >= 1; i--) {
            sum += cnpj.number.full.charAt(sizes.prefix - i) * positionIndex--;

            if (positionIndex < 2) {
                positionIndex = 9;
            }
        }

        result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

        if (result !== Number(cnpj.number.suffix.charAt(1))) {
            setInvalidInput({ input: cnpjInput });
            return;
        }

        setValidInput({ input: cnpjInput });
        return true;
    }

    checkCPF(cpfInput) {
        const sanitizedCpf = this.sanitize(cpfInput.value);

        const cpf = {
            fullNumber: sanitizedCpf,
            prefix: sanitizedCpf.slice(0, 9),
            suffix: sanitizedCpf.slice(9, 11),
        };

        if (!cpf.fullNumber || cpf.fullNumber.length !== this.sizes.cpf) {
            setInvalidInput({ input: cpfInput });
            return;
        }

        if (/^(\d)\1+$/.test(cpf.fullNumber)) {
            setInvalidInput({ input: cpfInput });
            return;
        }

        let d1 = 0;

        for (let i = 0; i < 9; i++) {
            d1 += cpf.prefix.charAt(i) * (10 - i);
        }

        if (d1 === 0) {
            setInvalidInput({ input: cpfInput });
            return;
        }

        d1 = 11 - (d1 % 11);

        if (d1 > 9) {
            d1 = 0;
        }

        if (Number(cpf.suffix.charAt(0)) !== d1) {
            setInvalidInput({ input: cpfInput });
            return;
        }

        d1 *= 2;

        for (let i = 0; i < 9; i++) {
            d1 += cpf.prefix.charAt(i) * (11 - i);
        }

        d1 = 11 - (d1 % 11);

        if (d1 > 9) {
            d1 = 0;
        }

        if (Number(cpf.suffix.charAt(1)) !== d1) {
            setInvalidInput({ input: cpfInput });
            return;
        }

        setValidInput({ input: cpfInput });
        return true;
    }
}
