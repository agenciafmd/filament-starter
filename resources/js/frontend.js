import {
    setupSmoothScroll,
    setupSmoothScrollInDrawer,
} from "./components/smooth-scroll.js";
import { CpfCnpjValidators } from "./helpers/cpf-cnpj-validators.js";
import {
    guideUserToTheFirstError,
    initializeFormHelpers,
} from "./helpers/form-helpers.js";
import { setupUtmHelpers } from "./helpers/utm-helper.js";
import { setupFmdHeader } from "./components/fmd-header.js";
import { setupColorMode } from "./components/color-mode.js";
import mask from "@alpinejs/mask";
import Popover from "bootstrap/js/dist/popover.js";
import Toast from "bootstrap/js/dist/toast.js";
import Tooltip from "bootstrap/js/dist/tooltip.js";

export function getThemeVariables() {
    const root = getComputedStyle(document.documentElement);

    // Read 'from --bs-breakpoint-??' (min-width)
    const breakpoints = {
        xs: Number(
            root.getPropertyValue("--bs-breakpoint-xs").replace("px", ""),
        ),
        sm: Number(
            root.getPropertyValue("--bs-breakpoint-sm").replace("px", ""),
        ),
        md: Number(
            root.getPropertyValue("--bs-breakpoint-md").replace("px", ""),
        ),
        lg: Number(
            root.getPropertyValue("--bs-breakpoint-lg").replace("px", ""),
        ),
        xl: Number(
            root.getPropertyValue("--bs-breakpoint-xl").replace("px", ""),
        ),
    };

    function isWindowWidthUp(breakpoint) {
        return window.innerWidth >= breakpoints[breakpoint];
    }

    function isWindowWidthDown(breakpoint) {
        return window.innerWidth < breakpoints[breakpoint];
    }

    return {
        breakpoints,
        collapseTransitionTime: 350, // In milliseconds
        colors: {
            primary: root.getPropertyValue("--bs-primary-base"),
            secondary: root.getPropertyValue("--bs-secondary-base"),
            success: root.getPropertyValue("--bs-success-base"),
            info: root.getPropertyValue("--bs-info-base"),
            warning: root.getPropertyValue("--bs-warning-base"),
            danger: root.getPropertyValue("--bs-danger-base"),
            light: root.getPropertyValue("--bs-light-base"),
            dark: root.getPropertyValue("--bs-dark-base"),
        },
        isWindowWidthUp,
        isWindowWidthDown,
    };
}

// Downloaded once and shared by the state/city selects and the CEP search
let statesRequest;

function loadStates() {
    statesRequest ??= fetch("/json/estados-cidades.json").then((response) =>
        response.json(),
    );

    return statesRequest;
}

function setupStateCityOptions() {
    const stateSelect = document.querySelector(".js-state");
    const citySelect = document.querySelector(".js-city");

    if (!stateSelect) {
        return;
    }

    loadStates()
        .then((data) => {
            let stateOptions = '<option value="">-</option>';

            data.forEach((state) => {
                const selected =
                    state.nome === stateSelect.getAttribute("data-selected")
                        ? "selected"
                        : "";
                stateOptions += `<option value="${state.nome}" ${selected}>${state.nome}</option>`;
            });

            stateSelect.innerHTML = stateOptions;

            stateSelect.addEventListener("change", () => {
                let cityOptions = '<option value="">-</option>';
                const selectedState = stateSelect.value;

                data.forEach((state) => {
                    if (state.nome !== selectedState) {
                        return;
                    }

                    state.cidades.forEach((city) => {
                        const selected =
                            city === citySelect.getAttribute("data-selected")
                                ? "selected"
                                : "";
                        cityOptions += `<option value="${city}" ${selected}>${city}</option>`;
                    });
                });

                citySelect.innerHTML = cityOptions;
            });

            stateSelect.dispatchEvent(new Event("change"));
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
}

function preventInvalidFormSubmit() {
    const forms = document.querySelectorAll(".needs-validation");

    forms.forEach((form) => {
        form.addEventListener(
            "submit",
            function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();

                    guideUserToTheFirstError(form);
                    form.classList.add("was-validated");
                    // Bootstrap 6 styles the invalid fields (`:user-invalid`) only inside `[data-bs-validate]`
                    form.dataset.bsValidate = "";
                }
            },
            false,
        );
    });

    setupInvalidElements();

    function setupInvalidElements() {
        const invalidElements = document.querySelectorAll(".is-invalid");

        invalidElements.forEach((element) => {
            element.setCustomValidity("needs validate");

            element.addEventListener("focusout", () => {
                element.classList.remove("is-invalid");
                element.setCustomValidity("");
            });
        });
    }
}

function verifyUserAgent() {
    const operationalSystemsData = [
        {
            osUserAgent: "Windows NT 10.0",
            osSystemName: "Windows 10",
        },
        {
            osUserAgent: "Windows NT 6.2",
            osSystemName: "Windows 8",
        },
        {
            osUserAgent: "Windows NT 6.1",
            osSystemName: "Windows 7",
        },
        {
            osUserAgent: "Windows NT 6.0",
            osSystemName: "Windows Vista",
        },
        {
            osUserAgent: "Windows NT 5.1",
            osSystemName: "Windows XP",
        },
        {
            osUserAgent: "Windows NT 5.0",
            osSystemName: "Windows 2000",
        },
        {
            osUserAgent: "Mac",
            osSystemName: "Mac/iOS",
        },
        {
            osUserAgent: "X11",
            osSystemName: "UNIX",
        },
        {
            osUserAgent: "Linux",
            osSystemName: "Linux",
        },
    ];

    const operationalSystemName = operationalSystemsData.reduce(
        (previousSystemData, currentSystemdata) => {
            if (
                window.navigator.userAgent.indexOf(
                    currentSystemdata.osUserAgent,
                ) !== -1
            ) {
                return currentSystemdata.osSystemName;
            }

            return previousSystemData;
        },
    );

    if (operationalSystemName !== "Mac/iOS") {
        let body = document.querySelector("body");
        body.classList.add("style-scroll");
    }
}

function onChangeSelectLink() {
    // Switch page action when links are in a select
    // e.g. to do in html
    // <select class="form-control js-onchange">
    //   <option value=""
    //     selected>Link
    //   </option>
    //   <option class="" value="/html/index">Home</option>
    //   <option class="" value="/html/tema">FAQ</option>
    //</select>

    const selects = document.querySelectorAll(".js-onchange");

    selects.forEach((select) => {
        select.addEventListener("change", function () {
            window.location = select.value;
        });
    });
}

function getBrowser() {
    const userAgent = navigator.userAgent.toLowerCase();
    const hasUserAgentSafariToken = userAgent.indexOf("safari") > -1;
    const hasUserAgentChromeToken = userAgent.indexOf("chrome") > -1;

    if (hasUserAgentSafariToken) {
        if (hasUserAgentChromeToken) {
            return "chrome";
        }

        return "safari";
    }
}

function isSafari() {
    return getBrowser() === "safari";
}

function setupAlpine() {
    Alpine.plugin(mask);

    window.Alpine = Alpine;
}

function setupInputMasks() {
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

function setupCepSearch() {
    const zipcodeInputs = document.querySelectorAll(".js-zipcode");

    zipcodeInputs.forEach((zipcodeInput) => {
        zipcodeInput.addEventListener("blur", () => {
            const cep = zipcodeInput.value.replace(/\D/g, "");

            if (cep.length !== 8) {
                return;
            }

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    return response.json();
                })
                .then(async (result) => {
                    // ViaCEP answers 200 with `{ erro: true }` for an unknown CEP
                    if (!result || result.erro) {
                        console.warn("CEP não encontrado:", cep);
                        return;
                    }

                    const neighborhoodInput =
                        document.querySelector(".js-neighborhood");
                    const addressInput = document.querySelector(".js-address");
                    const stateInput = document.querySelector(".js-state");
                    const cityInput = document.querySelector(".js-city");

                    if (neighborhoodInput) {
                        neighborhoodInput.value = result.bairro;
                    }

                    if (addressInput) {
                        addressInput.value = result.logradouro;
                    }

                    if (stateInput?.tagName === "SELECT") {
                        // ViaCEP answers the UF ("SP"); the options of setupStateCityOptions use the name ("São Paulo")
                        const states = await loadStates();
                        const state = states.find(
                            ({ sigla }) => sigla === result.uf,
                        );

                        stateInput.value = state?.nome ?? "";
                        // Builds the city options before the city is set below
                        stateInput.dispatchEvent(new Event("change"));
                    } else if (stateInput) {
                        stateInput.value = result.uf;
                    }

                    if (cityInput) {
                        cityInput.value = result.localidade;
                    }
                })
                .catch((error) => {
                    console.error("Erro ao buscar o CEP:", error);
                });
        });
    });
}

export function setupPopover() {
    const popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]'),
    );

    popoverTriggerList.map((popoverTriggerEl) => {
        return new Popover(popoverTriggerEl, {});
    });
}

export function setupTooltip() {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    );

    tooltipTriggerList.map((tooltipTriggerEl) => {
        return new Tooltip(tooltipTriggerEl);
    });
}

export function setupToast() {
    const toastTriggerList = [].slice.call(
        document.querySelectorAll(".js-button-toast"),
    );

    toastTriggerList.map((toastTriggerEl) => {
        return toastTriggerEl.addEventListener("click", () => {
            Toast.getOrCreateInstance(
                toastTriggerEl.nextElementSibling.querySelector(".toast"),
            ).show();
        });
    });
}

function setupAnchorReloadPrevention() {
    const targetClickLinkElements = document.querySelectorAll('a[href="#"]');

    targetClickLinkElements.forEach(function (linkElement) {
        linkElement.addEventListener("click", function (clickEvent) {
            clickEvent.preventDefault();
        });
    });
}

async function setupInfiniteScroll() {
    const scrollContainerElement = document.querySelector(".infinite-scroll");
    const nextElementSelector = 'a[rel~="next"]';
    const nextPageElement = document.querySelector(nextElementSelector);

    if (!scrollContainerElement || !nextPageElement) {
        return;
    }

    const { default: InfiniteScroll } = await import("infinite-scroll");

    new InfiniteScroll(scrollContainerElement, {
        path: nextElementSelector,
        append: ".infinite-scroll-content",
        scrollThreshold: 100,
        status: ".page-load-status",
        history: "push",
    });
}

async function setupClipboardJS() {
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

async function setupWOWJS() {
    const { default: WOW } = await import("wow.js");

    new WOW().init();
}

(() => {
    preventInvalidFormSubmit();

    verifyUserAgent();

    setupSmoothScroll();

    setupSmoothScrollInDrawer();

    // setupCepSearch();

    // setupStateCityOptions();

    onChangeSelectLink();

    setupAlpine();

    setupInputMasks();

    // setupPopover();

    // setupTooltip();

    // setupAnchorReloadPrevention();

    initializeFormHelpers();

    // setupDefaultSlider();

    // setupClipboardJS();

    // setupShareAPI();

    // setupDataLayerEventClickButton();

    setupUtmHelpers();

    // setupWOWJS();

    setupColorMode();
})();

window.addEventListener("load", () => {
    /**
     * Usually the header triggers after the first section which has the
     * height defined as 100vh. We need the starting function here because
     * vh/vw are calculated after all resources loaded*/
    setupFmdHeader();

    if (window.innerWidth > getThemeVariables().breakpoints.md) {
        // setupLax();
    }

    setupInfiniteScroll();
});
