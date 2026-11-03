<header class="header fmd-header">
    <nav class="navbar md:navbar-expand">
        <div class="container">
            <x-frontend::link
                link="/html"
                title="{{ config('app.name') }}"
                aria-label="{{ config('app.name') }}"
                icon="logo-fmd"
                class="navbar-brand icon-link-hover-none"
            />
            <dialog
                class="drawer drawer-end md:align-items-end"
                id="navbarDrawer"
                aria-labelledby="navbarDrawerLabel"
            >
                <div class="drawer-header">
                    <h2 class="drawer-title fs-base" id="navbarDrawerLabel">Menu</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar menu"></button>
                </div>
                <div class="drawer-body">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <x-frontend::link
                                link="/html"
                                title="Ir para Home"
                                aria-label="Link para Home"
                                label="Home"
                                class="nav-link active"
                            />
                        </li>
                        <li class="nav-item">
                            <x-frontend::link
                                link="/html/quem-somos"
                                title="Ir para Quem somos"
                                aria-label="Link para Quem somos"
                                label="Quem somos"
                                class="nav-link"
                            />
                        </li>
                        <li class="nav-item menu-hover">
                            <x-frontend::link
                                link="#"
                                title="Ir para Contato"
                                aria-label="Link para Contato"
                                label="Produtos"
                                role="button"
                                data-bs-toggle="menu"
                                data-bs-display="static"
                                data-bs-auto-close="outside"
                                aria-expanded="false"
                                class="nav-link menu-toggle"
                            />
                            <div class="menu">
                                <x-frontend::link
                                        link="/html/"
                                        title="Ir para Produto 1"
                                        aria-label="Link para Produto 1"
                                        label="Produto 1"
                                        class="menu-item"
                                    />
                                <x-frontend::link
                                        link="/html/"
                                        title="Ir para Produto 2"
                                        aria-label="Link para Produto 2"
                                        label="Produto 2"
                                        class="menu-item"
                                    />
                                <x-frontend::link
                                        link="/html/"
                                        title="Ir para Produto 3"
                                        aria-label="Link para Produto 3"
                                        label="Produto 3"
                                        class="menu-item"
                                    />
                            </div>
                        </li>
                        <li class="nav-item">
                            <x-frontend::link
                                link="/html/contato"
                                title="Ir para Contato"
                                aria-label="Link para Contato"
                                label="Contato"
                                class="nav-link"
                            />
                        </li>
                        {{-- Exemplo para o dialog
                        <li class="nav-item">
                          <x-frontend::link link="#"
                                            data-bs-dismiss="drawer"
                                            data-bs-target="#navbarDrawer"
                                            title="Ir para Dialog"
                                            aria-label="Link para Dialog"
                                            label="Dialog"
                                            class="nav-link js-scroll-top"/>
                        </li>
                        --}}
                    </ul>
                </div>
            </dialog>
            <button
                class="btn btn-text btn-icon color-mode-toggle ms-auto js-color-mode-toggle"
                type="button"
                title="Alternar tema"
                aria-label="Ativar tema escuro"
                aria-pressed="false"
            >
                <x-icon name="frontend-ic-moon" class="bi color-mode-icon-dark" />
                <x-icon name="frontend-ic-sun" class="bi color-mode-icon-light" />
            </button>
            <button
                class="navbar-toggler"
                type="button"
                title="Menu"
                data-bs-toggle="drawer"
                data-bs-target="#navbarDrawer"
                aria-controls="navbarDrawer"
                aria-label="Menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>
