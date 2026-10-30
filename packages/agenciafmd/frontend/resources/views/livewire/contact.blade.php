<div
    id="formCard"
    class="bg-secondary stretch-on-mobile px-1h pe-auto md:px-1hq xl:px-2q md:py-1hq xl:py-3 rounded-md py-3"
>
    <h2 class="fg-light fs-5 md:fs-6 xl:fs-4 fw-medium fs-3 md:fs-5 xl:fs-3 ls-xl mb-0">
        Fale com nossos consultores
        <span class="fg-info"> e garanta o seu terreno </span>
    </h2>
    <form wire:submit.prevent="submit" class="needs-validation" novalidate>
        <div class="row gx-0 gy-1h md:gy-0hq xl:gy-1h">
            <div class="col-12">
                <div class="form-floating">
                    <label for="name" class="form-label">Nome </label>
                    <input
                        wire:model.lazy="name"
                        type="text"
                        id="name"
                        autocomplete="off"
                        placeholder=""
                        aria-label="nome"
                        class="@error('name') is-invalid @enderror form-control"
                    />
                    @error('name')
                        <span class="invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <label for="email" class="form-label">E-mail </label>
                    <input
                        wire:model.lazy="email"
                        type="email"
                        id="email"
                        autocomplete="off"
                        placeholder=""
                        aria-label="email"
                        class="@error('email') is-invalid @enderror form-control"
                    />
                    @error('email')
                        <span class="invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <label for="phone" class="form-label"> Telefone/celular </label>
                    <input
                        wire:model.lazy="phone"
                        x-mask:dynamic="$input.length <= 14 ? '(99) 9999-9999' : '(99) 99999-9999'"
                        x-data
                        type="tel"
                        id="phone"
                        autocomplete="off"
                        placeholder=""
                        aria-label="telefone"
                        class="@error('phone') is-invalid @enderror form-control"
                    />
                    @error('phone')
                        <span class="invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-field mt-0h mb-1">
                    <input
                        wire:model.lazy="terms"
                        type="checkbox"
                        name="privacy-terms"
                        class="check @error('terms') is-invalid @enderror"
                        id="privacy-terms"
                    />
                    <label for="privacy-terms">
                        <x-frontend::privacy-terms-message />
                    </label>
                    @error('terms')
                        <span class="d-block invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    aria-label="Quero saber mais"
                    class="btn btn-solid theme-info fs-6 md:fs-xlarge xl:fs-6 p-1q md:p-1 xl:p-1q w-100"
                >
                    <span wire:loading.remove wire:target="submit">Quero saber mais </span>
                    <span wire:loading wire:target="submit">
                        Enviando...
                        <span class="spinner-grow spinner-grow spinner-sm ms-0h" role="status" aria-hidden="true"></span>
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
