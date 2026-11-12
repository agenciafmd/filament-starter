// Downloaded once and shared by the state/city selects and the CEP search
let statesRequest;

function loadStates() {
    statesRequest ??= fetch("/json/estados-cidades.json").then((response) =>
        response.json(),
    );

    return statesRequest;
}

export function setupStateCityOptions() {
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

export function setupCepSearch() {
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
