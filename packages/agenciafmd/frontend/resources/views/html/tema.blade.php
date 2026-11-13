@extends('frontend::html.master', [
    'bodyClass' => 'bg-body',
    'critical' => '',
    'stylesheet' => 'resources/scss/pages/theme.scss',
])

@section('title', 'Tema')
@section('description', 'Página para visualização de todos os componentes')

@section('content')
    <main class="py-block-small">
        <div class="container">
            <div class="row gx-1 gy-block-small">
                <div class="md:col-2">
                    <nav id="bd-sidebar-nav" class="bd-sidebar vstack gap-1h position-sticky md:h-100vh top-0 overflow-y-auto py-1" aria-label="Navegação do tema">
                        <div>
                            <h2 class="fs-small fw-semibold text-uppercase ls-md fg-2 mb-0h px-0h">Components</h2>
                            <ul id="nav-links-components" class="nav flex-column flex-nowrap">
                                @php
                                    $componentsLinks = [
                                        (object) ['name' => 'Accordion'],
                                        (object) ['name' => 'Alerts'],
                                        (object) ['name' => 'Avatar', 'new' => true],
                                        (object) ['name' => 'Badge'],
                                        (object) ['name' => 'Breadcrumb'],
                                        (object) ['name' => 'Buttons'],
                                        (object) ['name' => 'Button Group'],
                                        (object) ['name' => 'Button Share'],
                                        (object) ['name' => 'Card'],
                                        (object) ['name' => 'Dialog'],
                                        (object) ['name' => 'Drawer', 'new' => true],
                                        (object) ['name' => 'List Group'],
                                        (object) ['name' => 'Navbar'],
                                        (object) ['name' => 'Navs - Tabs'],
                                        (object) ['name' => 'Pagination'],
                                        (object) ['name' => 'Popovers'],
                                        (object) ['name' => 'Progress'],
                                        (object) ['name' => 'Social Network'],
                                        (object) ['name' => 'Stepper', 'new' => true],
                                        (object) ['name' => 'Toasts'],
                                        (object) ['name' => 'Toggler', 'new' => true],
                                        (object) ['name' => 'Tooltips'],
                                    ];
                                @endphp

                                @foreach ($componentsLinks as $link)
                                    <li class="nav-item">
                                        <x-frontend::link
                                            link="#{{ str($link->name)->slug() }}"
                                            aria-label="{{ $link->name }}"
                                            title="Ir para {{ $link->name }}"
                                            class="nav-link js-scroll-top hstack gap-0q align-items-center justify-content-start py-0q px-0h rounded-1 fs-small"
                                        >
                                            <span class="text-wrap min-w-0">{{ $link->name }}</span>
                                            @if ($link->new ?? false)
                                                <span class="badge badge-subtle theme-success fs-xsmall flex-shrink-0">Novo</span>
                                            @endif
                                        </x-frontend::link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h2 class="fs-small fw-semibold text-uppercase ls-md fg-2 mb-0h px-0h">Content</h2>
                            <ul id="nav-links-content" class="nav flex-column flex-nowrap">
                                @php
                                    $contentLinks = [
                                        (object) ['name' => 'Images'],
                                        (object) ['name' => 'Typography'],
                                        (object) ['name' => 'Tables'],
                                    ];
                                @endphp

                                @foreach ($contentLinks as $link)
                                    <li class="nav-item">
                                        <x-frontend::link
                                            link="#{{ str($link->name)->slug() }}"
                                            aria-label="{{ $link->name }}"
                                            title="Ir para {{ $link->name }}"
                                            class="nav-link js-scroll-top hstack gap-0q align-items-center justify-content-start py-0q px-0h rounded-1 fs-small"
                                        >
                                            <span class="text-wrap min-w-0">{{ $link->name }}</span>
                                            @if ($link->new ?? false)
                                                <span class="badge badge-subtle theme-success fs-xsmall flex-shrink-0">Novo</span>
                                            @endif
                                        </x-frontend::link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h2 class="fs-small fw-semibold text-uppercase ls-md fg-2 mb-0h px-0h">Forms</h2>
                            <ul id="nav-links-forms" class="nav flex-column flex-nowrap">
                                @php
                                    $formsLinks = [
                                        (object) ['name' => 'Form Control'],
                                        (object) ['name' => 'Form Field', 'new' => true],
                                        (object) ['name' => 'Form Adorn', 'new' => true],
                                        (object) ['name' => 'Select'],
                                        (object) ['name' => 'Combobox', 'new' => true],
                                        (object) ['name' => 'Checks / Radios'],
                                        (object) ['name' => 'Range'],
                                        (object) ['name' => 'Input Group'],
                                        (object) ['name' => 'Floating Label'],
                                        (object) ['name' => 'Validation'],
                                        (object) ['name' => 'Search'],
                                        (object) ['name' => 'Datepicker', 'new' => true],
                                        (object) ['name' => 'Chips', 'new' => true],
                                        (object) ['name' => 'OTP Input', 'new' => true],
                                        (object) ['name' => 'Password Strength', 'new' => true],
                                        (object) ['name' => 'Livewire'],
                                    ];
                                @endphp

                                @foreach ($formsLinks as $link)
                                    <li class="nav-item">
                                        <x-frontend::link
                                            link="#{{ str($link->name)->slug() }}"
                                            aria-label="{{ $link->name }}"
                                            title="Ir para {{ $link->name }}"
                                            class="nav-link js-scroll-top hstack gap-0q align-items-center justify-content-start py-0q px-0h rounded-1 fs-small"
                                        >
                                            <span class="text-wrap min-w-0">{{ $link->name }}</span>
                                            @if ($link->new ?? false)
                                                <span class="badge badge-subtle theme-success fs-xsmall flex-shrink-0">Novo</span>
                                            @endif
                                        </x-frontend::link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h2 class="fs-small fw-semibold text-uppercase ls-md fg-2 mb-0h px-0h">Helpers</h2>
                            <ul id="nav-links-helpers" class="nav flex-column flex-nowrap">
                                @php
                                    $iconLinks = [
                                        (object) ['name' => 'Accessibility'],
                                        (object) ['name' => 'Gallery'],
                                        (object) ['name' => 'Hover Lift', 'new' => true],
                                        (object) ['name' => 'Icons'],
                                        (object) ['name' => 'Icon link'],
                                        (object) ['name' => 'List icon'],
                                        (object) ['name' => 'Infinite scroll'],
                                        (object) ['name' => 'Pwa icons'],
                                        (object) ['name' => 'Text Balance', 'new' => true],
                                        (object) ['name' => 'Vídeo'],
                                        (object) ['name' => 'Slider'],
                                    ];
                                @endphp

                                @foreach ($iconLinks as $link)
                                    <li class="nav-item">
                                        <x-frontend::link
                                            link="#{{ str($link->name)->slug() }}"
                                            aria-label="{{ $link->name }}"
                                            title="Ir para {{ $link->name }}"
                                            class="nav-link js-scroll-top hstack gap-0q align-items-center justify-content-start py-0q px-0h rounded-1 fs-small"
                                        >
                                            <span class="text-wrap min-w-0">{{ $link->name }}</span>
                                            @if ($link->new ?? false)
                                                <span class="badge badge-subtle theme-success fs-xsmall flex-shrink-0">Novo</span>
                                            @endif
                                        </x-frontend::link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="md:col-10">
                    {{-- A single ScrollSpy for every group, so only one sidebar link is active at a time --}}
                    <div
                        class="vstack gap-block-small md:gap-block"
                        data-bs-spy="scroll"
                        data-bs-target="#bd-sidebar-nav"
                        data-bs-smooth-scroll="true"
                    >
                        <div class="bd-example">
                            <h2 class="mb-block-small h6">Design System do {{ config('app.name') }}</h2>
                            <p>
                                Bem-vindo ao Design System do projeto {{ config('app.name') }}, um guia completo para a
                                construção de interfaces consistentes, acessíveis e escaláveis. Aqui, centralizamos os
                                padrões visuais, componentes reutilizáveis e diretrizes que garantem uma experiência
                                coesa em todo o nosso ecossistema digital.
                            </p>
                            <p>
                                Nosso objetivo é facilitar o desenvolvimento, promover a identidade da marca e otimizar
                                a colaboração entre designers e desenvolvedores.
                            </p>
                            <p>
                                📖 Explore nossa documentação para conhecer os princípios, tokens de design e
                                componentes disponíveis.
                            </p>
                            <p class="text-end">
                                <x-frontend::link
                                    link="//fmd.ag"
                                    is-extern="true"
                                    class="icon-link icon-link-hover-pulse text-decoration-none"
                                    title="Agência F&MD"
                                >
                                    <span class="bi w-auto"> Feito com ❤️ por Agência F&MD </span>
                                </x-frontend::link>
                            </p>
                        </div>

                        <div
                            class="vstack gap-block-small md:gap-block"
                        >
                            <section id="accordion" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Accordion
                                    <a href="#accordion" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Accordion">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <x-frontend::accordions.accordion-faq></x-frontend::accordions.accordion-faq>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="alerts" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Alerts
                                    <a href="#alerts" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Alerts">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row g-1">
                                                <div class="md:col-4">
                                                    <x-frontend::alert
                                                        message="An example alert primary"
                                                        class="theme-primary"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <x-frontend::alert
                                                        message="An example alert secondary"
                                                        class="theme-secondary"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <x-frontend::alert message="An example alert info" class="theme-info" />
                                                </div>
                                                <div class="md:col-4">
                                                    <x-frontend::alert
                                                        message="An example alert warning"
                                                        class="theme-warning"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <x-frontend::alert
                                                        message="An example alert danger"
                                                        class="theme-danger"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <x-frontend::alert
                                                        message="An example alert success"
                                                        class="theme-success"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of an alert with an icon and a link</h2>

                                            <x-frontend::alert
                                                icon="ic-info"
                                                icon-class="ic-sm"
                                                class="theme-primary hstack align-items-center gap-1"
                                            >
                                                <p>
                                                    An example alert primary with
                                                    <x-frontend::link link="#" class="alert-heading" label="link" />
                                                </p>
                                            </x-frontend::alert>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of an alert with an icon, link, and btn-close</h2>

                                            <x-frontend::alert
                                                icon="ic-info"
                                                icon-class="ic-sm"
                                                has-dismissible="true"
                                                class="theme-primary hstack align-items-center gap-1"
                                            >
                                                <p class="mb-0">
                                                    An example alert primary with
                                                    <x-frontend::link link="#" class="alert-heading" label="link" />
                                                </p>
                                            </x-frontend::alert>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">
                                                Example of an alert with an icon, title, link, and btn-close
                                            </h2>

                                            <x-frontend::alert has-dismissible="true" class="theme-primary hstack align-items-center gap-1">
                                                <x-icon name="frontend-ic-info" class="bi ic-sm flex-shrink-0" />
                                                <div>
                                                    <h4 class="mb-0">Title alert</h4>
                                                    <p class="mb-0">
                                                        An example alert primary with
                                                        <x-frontend::link link="#" class="alert-heading" label="link" />
                                                    </p>
                                                </div>
                                            </x-frontend::alert>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="avatar" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Avatar <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#avatar" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Avatar Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="hstack gap-1 flex-wrap align-items-center">
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar extra pequeno" size="xs" />
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar pequeno" size="sm" />
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar online" status="online" />
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar ausente" size="lg" status="away" />
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar ocupado" size="lg" status="busy" />
                                        <x-frontend::avatar image="ratios/img-1x1.jpg" title="Avatar offline" size="lg" status="offline" />
                                        <div class="avatar-stack">
                                            <x-frontend::avatar image="ratios/img-1x1.jpg" title="Pessoa 1" />
                                            <x-frontend::avatar image="ratios/img-1x1.jpg" title="Pessoa 2" />
                                            <x-frontend::avatar image="ratios/img-1x1.jpg" title="Pessoa 3" />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="badge" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Badge
                                    <a href="#badge" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Badge">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <x-frontend::badge label="Primary" theme="theme-primary" />
                                            <x-frontend::badge label="Secondary" theme="theme-secondary" />
                                            <x-frontend::badge label="Success" theme="theme-success" />
                                            <x-frontend::badge label="Danger" theme="theme-danger" />
                                            <x-frontend::badge label="Warning" theme="theme-warning" />
                                            <x-frontend::badge label="Info" theme="theme-info" />
                                            <x-frontend::badge label="Light" theme="theme-light" />
                                            <x-frontend::badge label="Dark" theme="theme-dark" />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a badge outline</h2>

                                            <x-frontend::badge label="Primary" theme="text-bg-outline-primary" />
                                            <x-frontend::badge label="Secondary" theme="text-bg-outline-secondary" />
                                            <x-frontend::badge label="Success" theme="text-bg-outline-success" />
                                            <x-frontend::badge label="Danger" theme="text-bg-outline-danger" />
                                            <x-frontend::badge label="Warning" theme="text-bg-outline-warning" />
                                            <x-frontend::badge label="Info" theme="text-bg-outline-info" />
                                            <x-frontend::badge label="Light" theme="text-bg-outline-light" />
                                            <x-frontend::badge label="Dark" theme="text-bg-outline-dark" />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a badge pill</h2>

                                            <x-frontend::badge :is-rounded="true" label="Primary" theme="theme-primary" />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Secondary"
                                                theme="theme-secondary"
                                            />
                                            <x-frontend::badge :is-rounded="true" label="Success" theme="theme-success" />
                                            <x-frontend::badge :is-rounded="true" label="Danger" theme="theme-danger" />
                                            <x-frontend::badge :is-rounded="true" label="Warning" theme="theme-warning" />
                                            <x-frontend::badge :is-rounded="true" label="Info" theme="theme-info" />
                                            <x-frontend::badge :is-rounded="true" label="Light" theme="theme-light" />
                                            <x-frontend::badge :is-rounded="true" label="Dark" theme="theme-dark" />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a badge outline pill</h2>

                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Primary"
                                                theme="text-bg-outline-primary"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Secondary"
                                                theme="text-bg-outline-secondary"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Success"
                                                theme="text-bg-outline-success"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Danger"
                                                theme="text-bg-outline-danger"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Warning"
                                                theme="text-bg-outline-warning"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Info"
                                                theme="text-bg-outline-info"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Light"
                                                theme="text-bg-outline-light"
                                            />
                                            <x-frontend::badge
                                                :is-rounded="true"
                                                label="Dark"
                                                theme="text-bg-outline-dark"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a badge button</h2>

                                            <button type="button" class="btn btn-solid theme-primary">
                                                Notifications
                                                <x-frontend::badge label="4" theme="theme-secondary" />
                                            </button>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a positioned badge button</h2>

                                            <button type="button" class="btn btn-solid theme-primary position-relative">
                                                Inbox
                                                <x-frontend::badge class="position-absolute translate-middle badge rounded-pill bg-danger start-100 top-0">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </x-frontend::badge>
                                            </button>

                                            <button type="button" class="btn btn-solid theme-primary position-relative">
                                                Profile
                                                <x-frontend::badge class="position-absolute translate-middle p-0h bg-danger border-light rounded-circle start-100 top-0 border">
                                                    <span class="visually-hidden">New alerts</span>
                                                </x-frontend::badge>
                                                <span class="position-absolute translate-middle p-0h bg-danger border-light rounded-circle start-100 top-0 border">
                                                    <span class="visually-hidden">New alerts</span>
                                                </span>
                                            </button>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Badge subtle e outline <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <div class="hstack gap-1 flex-wrap">
                                                @foreach (['primary', 'success', 'info', 'warning', 'danger'] as $theme)
                                                    <span class="badge badge-subtle theme-{{ $theme }}">Subtle {{ $theme }}</span>
                                                    <span class="badge badge-outline theme-{{ $theme }}">Outline {{ $theme }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="breadcrumb" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Breadcrumb
                                    <a href="#breadcrumb" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Breadcrumb">#</a>
                                </h2>
                                <div class="bd-example overflow-hidden">
                                    <div class="vstack gap-1">
                                        @php
                                            $breadcrumb = [
                                                'Home' => '/html',
                                                'Produtos' => '/html/produtos',
                                                'Categoria' => '/html/produtos/categoria',
                                                'Nome do produto' => '',
                                            ];
                                        @endphp

                                        <div>
                                            @php
                                                $breadcrumb = [
                                                    'Home' => '/html',
                                                    'Produtos' => '/html/produtos',
                                                    'Categoria' => '/html/produtos/categoria',
                                                    'Nome do produto' => '',
                                                ];
                                            @endphp

                                            <x-frontend::breadcrumb :list="$breadcrumb" />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a dark breadcrumb</h2>
                                            <div class="bg-primary p-1">
                                                <x-frontend::breadcrumb :list="$breadcrumb" isDarkMode="true" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="buttons" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Buttons
                                    <a href="#buttons" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Buttons">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <button type="button" class="btn btn-solid theme-primary">Primary</button>
                                            <button type="button" class="btn btn-solid theme-secondary">Secondary</button>
                                            <button type="button" class="btn btn-solid theme-success">Success</button>
                                            <button type="button" class="btn btn-solid theme-info">Info</button>
                                            <button type="button" class="btn btn-solid theme-warning">Warning</button>
                                            <button type="button" class="btn btn-solid theme-danger">Danger</button>
                                            <button type="button" class="btn btn-solid theme-light">Light</button>
                                            <button type="button" class="btn btn-solid theme-dark">Dark</button>
                                            <button type="button" class="btn btn-link">Link</button>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-solid theme-primary disabled">Primary</button>
                                            <button type="button" class="btn btn-solid theme-secondary disabled">Secondary</button>
                                            <button type="button" class="btn btn-solid theme-success disabled">Success</button>
                                            <button type="button" class="btn btn-solid theme-info disabled">Info</button>
                                            <button type="button" class="btn btn-solid theme-warning disabled">Warning</button>
                                            <button type="button" class="btn btn-solid theme-danger disabled">Danger</button>
                                            <button type="button" class="btn btn-solid theme-light disabled">Light</button>
                                            <button type="button" class="btn btn-solid theme-dark disabled">Dark</button>
                                            <button type="button" class="btn btn-link disabled">Link</button>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-outline theme-primary">Primary</button>
                                            <button type="button" class="btn btn-outline theme-secondary">Secondary</button>
                                            <button type="button" class="btn btn-outline theme-success">Success</button>
                                            <button type="button" class="btn btn-outline theme-info">Info</button>
                                            <button type="button" class="btn btn-outline theme-warning">Warning</button>
                                            <button type="button" class="btn btn-outline theme-danger">Danger</button>
                                            <button type="button" class="btn btn-outline theme-light">Light</button>
                                            <button type="button" class="btn btn-outline theme-dark">Dark</button>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-solid theme-primary btn-lg">Large button</button>
                                            <button type="button" class="btn btn-solid theme-primary">Default button</button>
                                            <button type="button" class="btn btn-solid theme-primary btn-sm">Small button</button>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Button subtle, text, extra small e icon <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <div class="hstack gap-1 flex-wrap align-items-center">
                                                <button type="button" class="btn btn-subtle theme-primary">Subtle</button>
                                                <button type="button" class="btn btn-text theme-primary">Text</button>
                                                <button type="button" class="btn btn-solid theme-primary btn-xs">Extra small</button>
                                                <button type="button" class="btn btn-icon btn-solid theme-primary" aria-label="Pesquisar">
                                                    <x-icon name="frontend-ic-ui-arrow-right" class="ic-xxxsm" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="button-group" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Button Group
                                    <a href="#button-group" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Button Group">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic checkbox toggle button group"
                                            >
                                                <label class="btn-check btn-solid theme-primary">
                                                    <input
                                                    type="checkbox"
                                                    id="btncheck1"
                                                    checked
                                                    autocomplete="off"
                                                />
                                                    Checkbox 1
                                                </label>
                                                <label class="btn-check btn-solid theme-primary">
                                                    <input
                                                    type="checkbox"
                                                    id="btncheck2"
                                                    autocomplete="off"
                                                />
                                                    Checkbox 2
                                                </label>
                                                <label class="btn-check btn-solid theme-primary">
                                                    <input
                                                    type="checkbox"
                                                    id="btncheck3"
                                                    autocomplete="off"
                                                />
                                                    Checkbox 3
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <div
                                                class="btn-group"
                                                role="group"
                                                aria-label="Basic radio toggle button group"
                                            >
                                                <label class="btn-check btn-outline theme-primary">
                                                    <input
                                                    type="radio"
                                                    name="btnradio"
                                                    id="btnradio1"
                                                    autocomplete="off"
                                                    checked
                                                />
                                                    Radio 1
                                                </label>
                                                <label class="btn-check btn-outline theme-primary">
                                                    <input
                                                    type="radio"
                                                    name="btnradio"
                                                    id="btnradio2"
                                                    autocomplete="off"
                                                    checked
                                                />
                                                    Radio 2
                                                </label>
                                                <label class="btn-check btn-outline theme-primary">
                                                    <input
                                                    type="radio"
                                                    name="btnradio"
                                                    id="btnradio3"
                                                    autocomplete="off"
                                                    checked
                                                />
                                                    Radio 3
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="btn-group-vertical">
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                                <button type="button" class="btn btn-solid theme-primary">Button</button>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-solid theme-secondary">Left</button>
                                                <button type="button" class="btn btn-solid theme-secondary">Middle</button>
                                                <button type="button" class="btn btn-solid theme-secondary">Right</button>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <button type="button" class="btn btn-solid theme-secondary">1</button>
                                                    <button type="button" class="btn btn-solid theme-secondary">2</button>
                                                    <button type="button" class="btn btn-solid theme-secondary">3</button>
                                                    <button type="button" class="btn btn-solid theme-secondary">4</button>
                                                </div>
                                                <div class="btn-group me-2" role="group" aria-label="Second group">
                                                    <button type="button" class="btn btn-solid theme-secondary">5</button>
                                                    <button type="button" class="btn btn-solid theme-secondary">6</button>
                                                    <button type="button" class="btn btn-solid theme-secondary">7</button>
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Third group">
                                                    <button type="button" class="btn btn-solid theme-secondary">8</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="button-share" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Button Share
                                    <a href="#button-share" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Button Share">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <x-frontend::link
                                                href="#"
                                                role="button"
                                                data-fmd-share-btn-fbidentification="123456789123456"
                                                label="Compartilhar"
                                                class="btn btn-solid theme-secondary js-btn-share icon-link-hover-scale-center"
                                                icon="ic-share"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="card" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Card
                                    <a href="#card" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Card">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card>
                                                        <h5 class="card-title">Card title</h5>
                                                        <h6 class="card-subtitle fg-2 mb-2">
                                                            Card subtitle
                                                        </h6>
                                                        <p class="card-text">
                                                            Some quick example text to build on the card title and make up
                                                            the bulk of the card's content.
                                                        </p>
                                                        <x-frontend::link link="#" label="Card link" class="card-link" />
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card has-shadow="true" class="vstack bg-3">
                                                        <h5 class="card-title">Card title</h5>
                                                        <h6 class="card-subtitle fg-2 mb-2">
                                                            Card subtitle
                                                        </h6>
                                                        <p class="card-text">
                                                            Some quick example text to build on the card title and make up
                                                            the bulk of the card's content.
                                                        </p>
                                                        <x-frontend::link link="#" label="Card link" class="card-link" />
                                                    </x-frontend::cards.card>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="row">
                                                <hr />
                                                <h2 class="fs-xlarge">Example card with image</h2>
                                                <div class="md:col-6">
                                                    @php
                                                        $image = (object) [
                                                            'src' => 'ratios/img-16x9.jpg',
                                                            'name' => 'Imagem 16x9',
                                                            'pictureClass' => 'ratio ratio-16x9',
                                                            'imageClass' => 'img-cover',
                                                        ];
                                                    @endphp
                                                    <x-frontend::cards.card-picture
                                                        :image="$image"
                                                        cardBody="vstack pt-1"
                                                        class="bg-3 h-100 shadow"
                                                    >
                                                        <p class="card-text">
                                                            Some quick example text to build on the card title and make up
                                                            the bulk of the card's content.
                                                        </p>
                                                    </x-frontend::cards.card-picture>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Card row e subtle <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <div class="card card-row">
                                                        <x-frontend::image image="ratios/img-1x1.jpg" title="Imagem do card" alt="Imagem do card" class="w-25 object-fit-cover" />
                                                        <div class="card-body">
                                                            <h3 class="card-title">Card row</h3>
                                                            <p class="mb-0">Card horizontal com imagem ao lado do conteúdo.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <div class="card card-subtle theme-primary">
                                                        <div class="card-body">
                                                            <h3 class="card-title">Card subtle</h3>
                                                            <p class="mb-0">Card com fundo suave da cor do tema.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="dialog" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Dialog
                                    <a href="#dialog" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Dialog">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-primary"
                                                data-bs-toggle="dialog"
                                                data-bs-target="#dialogBase"
                                            >
                                                Dialog Base
                                            </button>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Dialog variants <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <div class="hstack gap-1 flex-wrap">
                                                <button type="button" class="btn btn-solid theme-primary" data-bs-toggle="dialog" data-bs-target="#dialogNonModal">
                                                    Não-modal
                                                </button>
                                                <button type="button" class="btn btn-solid theme-primary" data-bs-toggle="dialog" data-bs-target="#dialogSlideUp">
                                                    Slide up
                                                </button>
                                                <button type="button" class="btn btn-solid theme-primary" data-bs-toggle="dialog" data-bs-target="#dialogScrollable">
                                                    Scrollable
                                                </button>
                                            </div>

                                            <dialog class="dialog dialog-nonmodal" id="dialogNonModal" data-bs-modal="false" aria-labelledby="dialogNonModalTitle">
                                                <div class="dialog-header">
                                                    <h2 class="dialog-title fs-base" id="dialogNonModalTitle">Dialog não-modal</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Fechar"></button>
                                                </div>
                                                <div class="dialog-body">A página continua interativa enquanto este dialog está aberto.</div>
                                            </dialog>

                                            <dialog class="dialog dialog-slide-up" id="dialogSlideUp" aria-labelledby="dialogSlideUpTitle">
                                                <div class="dialog-header">
                                                    <h2 class="dialog-title fs-base" id="dialogSlideUpTitle">Dialog slide up</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Fechar"></button>
                                                </div>
                                                <div class="dialog-body">Este dialog entra deslizando de baixo para cima.</div>
                                            </dialog>

                                            <dialog class="dialog dialog-scrollable" id="dialogScrollable" aria-labelledby="dialogScrollableTitle">
                                                <div class="dialog-header">
                                                    <h2 class="dialog-title fs-base" id="dialogScrollableTitle">Dialog scrollable</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Fechar"></button>
                                                </div>
                                                <div class="dialog-body">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <p>
                                                            Parágrafo {{ $i }}. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus
                                                            consectetur culpa cupiditate, doloribus eos excepturi fugiat ipsa labore modi.
                                                        </p>
                                                    @endfor
                                                </div>
                                                <div class="dialog-footer">
                                                    <button type="button" class="btn btn-solid theme-primary" data-bs-dismiss="dialog">Fechar</button>
                                                </div>
                                            </dialog>

                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="drawer" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Drawer
                                    <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#drawer" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Drawer">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <p class="mb-0">Substitui o offcanvas do Bootstrap 5. O menu do header (<code>#navbarDrawer</code>) usa o drawer no mobile.</p>
                                        <div class="hstack gap-1 flex-wrap">
                                        <button type="button" class="btn btn-outline theme-primary" data-bs-toggle="drawer" data-bs-target="#drawerStart">Drawer início</button>
                                        <button type="button" class="btn btn-outline theme-primary" data-bs-toggle="drawer" data-bs-target="#drawerEnd">Drawer fim</button>
                                        <button type="button" class="btn btn-outline theme-primary" data-bs-toggle="drawer" data-bs-target="#drawerTop">Drawer topo</button>
                                        <button type="button" class="btn btn-outline theme-primary" data-bs-toggle="drawer" data-bs-target="#drawerBottom">Drawer base</button>
                                        <button type="button" class="btn btn-outline theme-primary" data-bs-toggle="drawer" data-bs-target="#drawerSheet">Drawer sheet</button>
                                        </div>
                                    </div>

                                    <dialog class="drawer drawer-start" id="drawerStart" aria-labelledby="drawerStartTitle">
                                        <div class="drawer-header">
                                            <h2 class="drawer-title fs-base" id="drawerStartTitle">Drawer início</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                        </div>
                                        <div class="drawer-body">Abre pela esquerda.</div>
                                    </dialog>

                                    <dialog class="drawer drawer-end" id="drawerEnd" aria-labelledby="drawerEndTitle">
                                        <div class="drawer-header">
                                            <h2 class="drawer-title fs-base" id="drawerEndTitle">Drawer fim</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                        </div>
                                        <div class="drawer-body">Abre pela direita (mesmo formato do menu do header).</div>
                                    </dialog>

                                    <dialog class="drawer drawer-top" id="drawerTop" aria-labelledby="drawerTopTitle">
                                        <div class="drawer-header">
                                            <h2 class="drawer-title fs-base" id="drawerTopTitle">Drawer topo</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                        </div>
                                        <div class="drawer-body">Abre pelo topo.</div>
                                    </dialog>

                                    <dialog class="drawer drawer-bottom" id="drawerBottom" aria-labelledby="drawerBottomTitle">
                                        <div class="drawer-header">
                                            <h2 class="drawer-title fs-base" id="drawerBottomTitle">Drawer base</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                        </div>
                                        <div class="drawer-body">Abre pela base.</div>
                                    </dialog>

                                    <dialog class="drawer drawer-bottom drawer-sheet" id="drawerSheet" aria-labelledby="drawerSheetTitle">
                                        <div class="drawer-header">
                                            <h2 class="drawer-title fs-base" id="drawerSheetTitle">Drawer sheet</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                        </div>
                                        <div class="drawer-body">Arraste para baixo ou use o botão para fechar.</div>
                                    </dialog>
                                </div>
                            </section>

                            <section id="list-group" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    List group
                                    <a href="#list-group" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para List group">#</a>
                                </h2>
                                <div class="bd-example">

                                    <div class="vstack gap-1">
                                        <div>
                                            <ul class="list-group d-inline-flex">
                                                <li class="list-group-item">An item</li>
                                                <li class="list-group-item">A second item</li>
                                                <li class="list-group-item">A third item</li>
                                                <li class="list-group-item">A fourth item</li>
                                                <li class="list-group-item">And a fifth one</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of an active list group</h2>

                                            <ul class="list-group d-inline-flex">
                                                <li class="list-group-item active" aria-current="true">An active item</li>
                                                <li class="list-group-item">A second item</li>
                                                <li class="list-group-item">A third item</li>
                                                <li class="list-group-item">A fourth item</li>
                                                <li class="list-group-item">And a fifth one</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of list group links/buttons</h2>

                                            <div class="list-group d-inline-flex">
                                                <x-frontend::link
                                                    link="#"
                                                    label="The current link item"
                                                    class="list-group-item list-group-item-action active"
                                                    aria-current="true"
                                                />

                                                <x-frontend::link
                                                    link="#"
                                                    label="A second link item"
                                                    class="list-group-item list-group-item-action"
                                                    aria-current="true"
                                                />

                                                <x-frontend::link
                                                    link="#"
                                                    label="A third link item"
                                                    class="list-group-item list-group-item-action"
                                                    aria-current="true"
                                                />

                                                <x-frontend::link
                                                    link="#"
                                                    label="A fourth link item"
                                                    class="list-group-item list-group-item-action"
                                                    aria-current="true"
                                                />

                                                <x-frontend::link
                                                    link="#"
                                                    label="A disabled link item"
                                                    class="list-group-item list-group-item-action"
                                                    aria-current="true"
                                                />
                                            </div>

                                            <div class="list-group d-inline-flex">
                                                <button
                                                    type="button"
                                                    class="list-group-item list-group-item-action active"
                                                    aria-current="true"
                                                >
                                                    The current button
                                                </button>
                                                <button type="button" class="list-group-item list-group-item-action">
                                                    A second button item
                                                </button>
                                                <button type="button" class="list-group-item list-group-item-action">
                                                    A third button item
                                                </button>
                                                <button type="button" class="list-group-item list-group-item-action">
                                                    A fourth button item
                                                </button>
                                                <button
                                                    type="button"
                                                    class="list-group-item list-group-item-action"
                                                    disabled
                                                >
                                                    A disabled button item
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a numbered list group</h2>

                                            <ol class="list-group list-group-numbered d-inline-flex">
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary fg-contrast-primary rounded-pill">14</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary fg-contrast-primary rounded-pill">14</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Subheading</div>
                                                        Content for list item
                                                    </div>
                                                    <span class="badge bg-primary fg-contrast-primary rounded-pill">14</span>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="navbar" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Navbar
                                    <a href="#navbar" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Navbar">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        @include('frontend::html.partials.header')

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a navbar-dark</h2>
                                            <nav class="navbar lg:navbar-expand bg-primary" data-bs-theme="dark">
                                                <div class="container-fluid">
                                                    <a class="navbar-brand" href="#">Navbar </a>
                                                    <button
                                                        class="navbar-toggler"
                                                        type="button"
                                                        data-bs-toggle="drawer"
                                                        data-bs-target="#navbarColor01"
                                                        aria-controls="navbarColor01"
                                                        aria-expanded="false"
                                                        aria-label="Toggle navigation"
                                                    >
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>

                                                    <dialog class="drawer drawer-end" id="navbarColor01" aria-labelledby="navbarColor01Label">
                                                        <div class="drawer-header">
                                                            <h2 class="drawer-title fs-base" id="navbarColor01Label">Navbar</h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                                        </div>
                                                        <div class="drawer-body">
                                                        <ul class="navbar-nav me-auto">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" href="#"
                                                                    >Home
                                                                    <span class="visually-hidden">(current)</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Features </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Pricing </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">About </a>
                                                            </li>
                                                            <li class="nav-item menu-hover">
                                                                <a
                                                                    class="nav-link menu-toggle"
                                                                    data-bs-toggle="menu"
                                                                    data-bs-display="static"
                                                                    href="#"
                                                                    role="button"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    >Dropdown
                                                                </a>
                                                                <div class="menu">
                                                                    <a class="menu-item" href="#">Action </a>
                                                                    <a class="menu-item" href="#">Another action </a>
                                                                    <a class="menu-item" href="#"
                                                                        >Something else here
                                                                    </a>
                                                                    <div class="menu-divider"></div>
                                                                    <a class="menu-item" href="#">Separated link </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <form class="d-flex">
                                                            <input
                                                                class="form-control sm:me-2"
                                                                type="text"
                                                                placeholder="Search"
                                                            />
                                                            <button class="btn btn-solid theme-secondary sm:my-0 my-2" type="submit">
                                                                Search
                                                            </button>
                                                        </form>
                                                        </div>
                                                    </dialog>
                                                </div>
                                            </nav>
                                        </div>
                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a navbar-dark</h2>
                                            <nav class="navbar lg:navbar-expand bg-dark" data-bs-theme="dark">
                                                <div class="container-fluid">
                                                    <a class="navbar-brand" href="#">Navbar </a>
                                                    <button
                                                        class="navbar-toggler"
                                                        type="button"
                                                        data-bs-toggle="drawer"
                                                        data-bs-target="#navbarColor02"
                                                        aria-controls="navbarColor02"
                                                        aria-expanded="false"
                                                        aria-label="Toggle navigation"
                                                    >
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>

                                                    <dialog class="drawer drawer-end" id="navbarColor02" aria-labelledby="navbarColor02Label">
                                                        <div class="drawer-header">
                                                            <h2 class="drawer-title fs-base" id="navbarColor02Label">Navbar</h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                                        </div>
                                                        <div class="drawer-body">
                                                        <ul class="navbar-nav me-auto">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" href="#"
                                                                    >Home
                                                                    <span class="visually-hidden">(current)</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Features </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Pricing </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">About </a>
                                                            </li>
                                                            <li class="nav-item menu-hover">
                                                                <a
                                                                    class="nav-link menu-toggle"
                                                                    data-bs-toggle="menu"
                                                                    data-bs-display="static"
                                                                    href="#"
                                                                    role="button"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    >Dropdown
                                                                </a>
                                                                <div class="menu">
                                                                    <a class="menu-item" href="#">Action </a>
                                                                    <a class="menu-item" href="#">Another action </a>
                                                                    <a class="menu-item" href="#"
                                                                        >Something else here
                                                                    </a>
                                                                    <div class="menu-divider"></div>
                                                                    <a class="menu-item" href="#">Separated link </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <form class="d-flex">
                                                            <input
                                                                class="form-control sm:me-2"
                                                                type="text"
                                                                placeholder="Search"
                                                            />
                                                            <button class="btn btn-solid theme-secondary sm:my-0 my-2" type="submit">
                                                                Search
                                                            </button>
                                                        </form>
                                                        </div>
                                                    </dialog>
                                                </div>
                                            </nav>
                                        </div>
                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a navbar-light</h2>
                                            <nav class="navbar lg:navbar-expand bg-light" data-bs-theme="light">
                                                <div class="container-fluid">
                                                    <a class="navbar-brand" href="#">Navbar </a>
                                                    <button
                                                        class="navbar-toggler"
                                                        type="button"
                                                        data-bs-toggle="drawer"
                                                        data-bs-target="#navbarColor03"
                                                        aria-controls="navbarColor03"
                                                        aria-expanded="false"
                                                        aria-label="Toggle navigation"
                                                    >
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>

                                                    <dialog class="drawer drawer-end" id="navbarColor03" aria-labelledby="navbarColor03Label">
                                                        <div class="drawer-header">
                                                            <h2 class="drawer-title fs-base" id="navbarColor03Label">Navbar</h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
                                                        </div>
                                                        <div class="drawer-body">
                                                        <ul class="navbar-nav me-auto">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" href="#"
                                                                    >Home
                                                                    <span class="visually-hidden">(current)</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Features </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">Pricing </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#">About </a>
                                                            </li>
                                                            <li class="nav-item menu-hover">
                                                                <a
                                                                    class="nav-link menu-toggle"
                                                                    data-bs-toggle="menu"
                                                                    data-bs-display="static"
                                                                    href="#"
                                                                    role="button"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    >Dropdown
                                                                </a>
                                                                <div class="menu">
                                                                    <a class="menu-item" href="#">Action </a>
                                                                    <a class="menu-item" href="#">Another action </a>
                                                                    <a class="menu-item" href="#"
                                                                        >Something else here
                                                                    </a>
                                                                    <div class="menu-divider"></div>
                                                                    <a class="menu-item" href="#">Separated link </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <form class="d-flex">
                                                            <input
                                                                class="form-control sm:me-2"
                                                                type="text"
                                                                placeholder="Search"
                                                            />
                                                            <button class="btn btn-solid theme-secondary sm:my-0 my-2" type="submit">
                                                                Search
                                                            </button>
                                                        </form>
                                                        </div>
                                                    </dialog>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="navs-tabs" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Navs
                                    <a href="#navs-tabs" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Navs">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <ul class="nav">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <ul class="nav justify-content-center">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <ul class="nav justify-content-end">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <ul class="nav vstack align-content-start">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-tabs</h2>

                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-tabs with a dropdown</h2>

                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
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
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-pills</h2>

                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-pills with a dropdown</h2>

                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
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
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-underline</h2>

                                            <ul class="nav nav-underline">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-pills with fill</h2>

                                            <ul class="nav nav-pills nav-fill">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of nav-pills with justify</h2>

                                            <ul class="nav nav-pills nav-justified">
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Active"
                                                        class="nav-link active"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link"
                                                    />
                                                </li>
                                                <li class="nav-item">
                                                    <x-frontend::link
                                                        link="#"
                                                        aria-current="page"
                                                        label="Link"
                                                        class="nav-link disabled"
                                                    />
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Nav overflow <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <div class="nav-overflow" data-bs-toggle="nav-overflow">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" aria-current="page" href="#">Início</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Produtos</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Serviços</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Sobre nós</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Trabalhe conosco</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Perguntas frequentes</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="pagination" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Pagination
                                    <a href="#pagination" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Pagination">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="Previous" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="1" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="2" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="3" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="Next" class="page-link" />
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of small pagination</h2>

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination pagination-sm">
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Previous" class="page-link">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="1" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="2" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="3" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Next" class="page-link">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of large pagination</h2>

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination pagination-lg">
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Previous" class="page-link">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="1" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="2" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="3" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Next" class="page-link">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of pagination with an icon</h2>

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Previous" class="page-link">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="1" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="2" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="3" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Next" class="page-link">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of pagination with disabled and active states</h2>

                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <li class="page-item disabled">
                                                        <x-frontend::link link="#" aria-label="Previous" class="page-link">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="1" class="page-link" />
                                                    </li>
                                                    <li class="page-item active">
                                                        <x-frontend::link link="#" label="2" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" label="3" class="page-link" />
                                                    </li>
                                                    <li class="page-item">
                                                        <x-frontend::link link="#" aria-label="Next" class="page-link">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </x-frontend::link>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="popovers" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Popovers
                                    <a href="#popovers" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Popovers">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="vstack md:flex-row gap-1">
                                            <button
                                                type="button"
                                                class="btn btn-lg btn-solid theme-danger"
                                                data-bs-toggle="popover"
                                                data-bs-title="Popover title"
                                                data-bs-content="And here's some amazing content. It's very engaging. Right?"
                                            >
                                                Click to toggle popover
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-container="body"
                                                data-bs-toggle="popover"
                                                data-bs-placement="top"
                                                data-bs-content="Top popover"
                                            >
                                                Popover on top
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-container="body"
                                                data-bs-toggle="popover"
                                                data-bs-placement="right"
                                                data-bs-content="Right popover"
                                            >
                                                Popover on right
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-container="body"
                                                data-bs-toggle="popover"
                                                data-bs-placement="bottom"
                                                data-bs-content="Bottom popover"
                                            >
                                                Popover on bottom
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-container="body"
                                                data-bs-toggle="popover"
                                                data-bs-placement="left"
                                                data-bs-content="Left popover"
                                            >
                                                Popover on left
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="progress" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Progress
                                    <a href="#progress" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Progress">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="vstack gap-1">
                                                @php
                                                    $progressBars = [

                                                        (object) [
                                                            'name' => 'Rede e esgoto',
                                                            'percentage' => '80%',
                                                        ],

                                                        (object) [
                                                            'name' => 'Terraplanagem',
                                                            'percentage' => '50%',
                                                        ],

                                                        (object) [
                                                            'name' => 'Rede de água pluvial',
                                                            'percentage' => '30%',
                                                        ],

                                                    ];
                                                @endphp

                                                <div class="row gy-2">
                                                    @foreach ($progressBars as $progress)
                                                        <div class="md:col-4">
                                                            <x-frontend::progress.bar :progress="$progress" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a label progress</h2>

                                            <x-frontend::progress.bar
                                                :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '25%']"
                                                :percentageEmbedded="true"
                                                progress-height="16px"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of progress background</h2>

                                            <div class="vstack gap-1">
                                                <x-frontend::progress.bar
                                                    :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '25%']"
                                                    :percentageEmbedded="true"
                                                    progress-height="16px"
                                                    theme="bg-success"
                                                />

                                                <x-frontend::progress.bar
                                                    :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '50%']"
                                                    :percentageEmbedded="true"
                                                    progress-height="16px"
                                                    theme="bg-info fg-dark"
                                                />

                                                <x-frontend::progress.bar
                                                    :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '75%']"
                                                    :percentageEmbedded="true"
                                                    progress-height="16px"
                                                    theme="bg-warning fg-dark"
                                                />

                                                <x-frontend::progress.bar
                                                    :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '100%']"
                                                    :percentageEmbedded="true"
                                                    progress-height="16px"
                                                    theme="bg-warning bg-danger"
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of animated progress stripes</h2>

                                            <x-frontend::progress.bar
                                                :progress="(object) ['name' => 'Exemplo de barra de progresso', 'percentage' => '100%']"
                                                :percentageEmbedded="true"
                                                progress-height="16px"
                                                theme="progress-bar-striped progress-bar-animated"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of progress circle</h2>

                                            <x-frontend::progress.circle percentage="70" />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="social-network" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Social network
                                    <a href="#social-network" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Social network">#</a>
                                </h2>
                                <div class="bd-example">
                                    <x-frontend::social-network
                                        class="hover:fg-secondary icon-link flex-grow-0"
                                        iconClass="bi ic-sm"
                                    />
                                </div>
                            </section>

                            <section id="stepper" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Stepper <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#stepper" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Stepper Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <ol class="stepper">
                                            <li class="stepper-item active">Criar conta</li>
                                            <li class="stepper-item active">Confirmar e-mail</li>
                                            <li class="stepper-item">Atualizar perfil</li>
                                            <li class="stepper-item">Finalizar</li>
                                        </ol>
                                        <div class="contains-inline">
                                            <ol class="stepper md:stepper-horizontal">
                                                <li class="stepper-item active">Carrinho</li>
                                                <li class="stepper-item active">Entrega</li>
                                                <li class="stepper-item">Pagamento</li>
                                                <li class="stepper-item">Confirmação</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="toasts" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Toasts
                                    <a href="#toasts" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Toasts">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="vstack gap-1">
                                            <div>
                                                <div
                                                    class="toast d-block show"
                                                    role="alert"
                                                    aria-live="assertive"
                                                    aria-atomic="true"
                                                >
                                                    <div class="toast-header">
                                                        <strong class="me-auto">Bootstrap</strong>
                                                        <small>11 mins ago</small>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="toast"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="toast-body">Hello, world! This is a toast message.</div>
                                                </div>
                                            </div>

                                            <div>
                                                <button type="button" class="btn btn-solid theme-primary js-button-toast">Toast</button>

                                                <div class="toast-container position-fixed end-0 bottom-0 p-3">
                                                    <div
                                                        class="toast"
                                                        role="alert"
                                                        aria-live="assertive"
                                                        aria-atomic="true"
                                                    >
                                                        <div class="toast-header">
                                                            <strong class="me-auto">Bootstrap</strong>
                                                            <small>11 mins ago</small>
                                                            <button
                                                                type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="toast"
                                                                aria-label="Close"
                                                            ></button>
                                                        </div>
                                                        <div class="toast-body">Hello, world! This is a toast message.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="toggler" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Toggler <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#toggler" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Toggler Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div
                                        class="w-100 p-1 rounded border"
                                        data-bs-toggle="toggler"
                                        data-bs-value="fg-danger"
                                        data-bs-attribute="class"
                                    >
                                        Clique para alternar a classe <code>fg-danger</code>
                                    </div>
                                </div>
                            </section>

                            <section id="tooltips" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Tooltips
                                    <a href="#tooltips" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Tooltips">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="vstack md:flex-row gap-1">
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="This top tooltip is themed via CSS variables."
                                            >
                                                Custom tooltip
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="Tooltip on top"
                                            >
                                                Tooltip on top
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="right"
                                                data-bs-title="Tooltip on right"
                                            >
                                                Tooltip on right
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                data-bs-title="Tooltip on bottom"
                                            >
                                                Tooltip on bottom
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-solid theme-secondary"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                data-bs-title="Tooltip on left"
                                            >
                                                Tooltip on left
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div
                            class="vstack gap-block-small md:gap-block"
                        >
                            <section id="images" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Images
                                    <a href="#images" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Images">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <picture class="ratio ratio-16x9">
                                                            <x-frontend::image
                                                                image="ratios/img-16x9.jpg"
                                                                title="imagem titulo"
                                                                alt="imagem alt"
                                                                class="img-cover"
                                                            />
                                                        </picture>
                                                        <small class="text-center">
                                                            <kbd>Componente x-frontend::imagem</kbd>
                                                        </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <picture class="ratio ratio-16x9">
                                                            <x-frontend::single-source
                                                                image="ratios/img-16x9.jpg"
                                                                title="imagem titulo"
                                                                alt="imagem alt"
                                                                class="img-cover"
                                                            />
                                                        </picture>
                                                        <small class="text-center">
                                                            <kbd>Componente x-frontend::single-source</kbd>
                                                        </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::picture
                                                            image="ratios/img-16x9.jpg"
                                                            title="imagem titulo"
                                                            alt="imagem alt"
                                                            pictureClass="ratio ratio-16x9"
                                                            class="img-cover"
                                                            has-breakpoints="true"
                                                            breakpointDesktopWidth="1400px"
                                                            breakpointDesktopSuffix="xl"
                                                            breakpointNotebookWidth="768px"
                                                            breakpointNotebookSuffix="lg"
                                                        />
                                                        <small class="text-center">
                                                            <kbd>Componente x-frontend::picture</kbd>
                                                        </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="typography" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Typography
                                    <a href="#typography" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Typography">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <h1>Heading 1</h1>
                                            <h2>Heading 2</h2>
                                            <h3>Heading 3</h3>
                                            <h4>Heading 4</h4>
                                            <h5>Heading 5</h5>
                                            <h6>Heading 6</h6>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of text-muted and lead</h2>
                                            <h3>
                                                Heading
                                                <small class="fg-2">with muted text</small>
                                            </h3>
                                            <p class="lead">
                                                Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.
                                            </p>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of body text</h2>
                                            <p>
                                                Nullam quis risus eget
                                                <x-frontend::link link="#" label="urna mollis ornare" />
                                                vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes,
                                                nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.
                                            </p>
                                            <p>
                                                <small>This line of text is meant to be treated as fine print. </small>
                                            </p>
                                            <p>The following is <strong>rendered as bold text</strong>.</p>
                                            <p>The following is <em>rendered as italicized text</em>.</p>
                                            <p>
                                                An abbreviation of the word attribute is
                                                <abbr title="attribute">attr</abbr>.
                                            </p>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of list-unstyled</h2>
                                            <ul class="list-unstyled">
                                                <li>This is a list.</li>
                                                <li>It appears completely unstyled.</li>
                                                <li>Structurally, it's still a list.</li>
                                                <li>However, this style only applies to immediate child elements.</li>
                                                <li>
                                                    Nested lists:
                                                    <ul>
                                                        <li>are unaffected by this style</li>
                                                        <li>will still show a bullet</li>
                                                        <li>and have appropriate left margin</li>
                                                    </ul>
                                                </li>
                                                <li>This may still come in handy in some situations.</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of list-inline</h2>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">This is a list item.</li>
                                                <li class="list-inline-item">And another one.</li>
                                                <li class="list-inline-item">But they're displayed inline.</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of blockquotes</h2>
                                            <div class="row gy-block-small">
                                                <div class="md:col-4">
                                                    <figure>
                                                        <blockquote class="blockquote">
                                                            <p class="mb-0">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                Integer posuere erat a ante.
                                                            </p>
                                                        </blockquote>
                                                        <figcaption class="blockquote-footer">
                                                            Someone famous in
                                                            <cite title="Source Title"> Source Title</cite>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                                <div class="md:col-4">
                                                    <figure class="text-center">
                                                        <blockquote class="blockquote">
                                                            <p class="mb-0">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                Integer posuere erat a ante.
                                                            </p>
                                                        </blockquote>
                                                        <figcaption class="blockquote-footer">
                                                            Someone famous in
                                                            <cite title="Source Title"> Source Title</cite>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                                <div class="md:col-4">
                                                    <figure class="text-end">
                                                        <blockquote class="blockquote">
                                                            <p class="mb-0">
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                Integer posuere erat a ante.
                                                            </p>
                                                        </blockquote>
                                                        <figcaption class="blockquote-footer">
                                                            Someone famous in
                                                            <cite title="Source Title"> Source Title</cite>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge hstack align-items-center gap-0h">Prose <span class="badge badge-subtle theme-success fs-xsmall">Novo</span></h2>

                                            <article class="prose border rounded-1 p-1">
                                                <h2>Título do artigo</h2>
                                                <p>
                                                    O <code>.prose</code> aplica tipografia a conteúdo vindo de editores (WYSIWYG), sem precisar de classes
                                                    em cada elemento.
                                                </p>
                                                <ul>
                                                    <li>Listas</li>
                                                    <li>Citações e tabelas</li>
                                                </ul>
                                                <blockquote>Uma citação de exemplo.</blockquote>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="tables" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Tables
                                    <a href="#tables" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Tables">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <table class="table-hover table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Column heading</th>
                                                    <th scope="col">Column heading</th>
                                                    <th scope="col">Column heading</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-active">
                                                    <th scope="row">Active</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Default</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-primary">
                                                    <th scope="row">Primary</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-secondary">
                                                    <th scope="row">Secondary</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-success">
                                                    <th scope="row">Success</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-danger">
                                                    <th scope="row">Danger</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-warning">
                                                    <th scope="row">Warning</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-info">
                                                    <th scope="row">Info</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-light">
                                                    <th scope="row">Light</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                                <tr class="theme-dark">
                                                    <th scope="row">Dark</th>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                    <td>Column content</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div
                            class="vstack gap-block-small md:gap-block"
                        >
                            <section id="form-control" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Form Control
                                    <a href="#form-control" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Form Control">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row gy-block-small">
                                                <div class="md:col-6">
                                                    <label for="exampleFormControlInput1" class="form-label"
                                                        >Example input
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleFormControlInput1"
                                                        placeholder=""
                                                    />
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="exampleFormControlTextarea1" class="form-label"
                                                        >Example textarea
                                                    </label>
                                                    <textarea
                                                        class="form-control"
                                                        id="exampleFormControlTextarea1"
                                                        rows="3"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of sizing</h2>

                                            <div class="row gy-block-small">
                                                <div class="md:col-4">
                                                    <label class="col-form-label col-form-label-sm" for="inputSmall"
                                                        >Small input
                                                    </label>
                                                    <input
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        placeholder=".form-control-sm"
                                                        id="inputSmall"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <label class="col-form-label" for="inputDefault">Default input </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Default input"
                                                        id="inputDefault"
                                                    />
                                                </div>
                                                <div class="md:col-4">
                                                    <label class="col-form-label col-form-label-lg" for="inputLarge"
                                                        >Large input
                                                    </label>
                                                    <input
                                                        class="form-control form-control-lg"
                                                        type="text"
                                                        placeholder=".form-control-lg"
                                                        id="inputLarge"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of form text</h2>

                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <label for="inputPassword6" class="col-form-label">Password </label>
                                                </div>
                                                <div class="col-12">
                                                    <input
                                                        type="password"
                                                        id="inputPassword6"
                                                        class="form-control"
                                                        aria-describedby="passwordHelpInline"
                                                    />
                                                </div>
                                                <div class="col-12">
                                                    <span id="passwordHelpInline" class="form-text">
                                                        Must be 8-20 characters long.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled input</h2>

                                            <div>
                                                <label class="form-label" for="disabledInput">Disabled input </label>
                                                <input
                                                    class="form-control"
                                                    id="disabledInput"
                                                    type="text"
                                                    placeholder="Disabled input here..."
                                                    disabled
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a readonly input</h2>

                                            <div>
                                                <label class="form-label" for="readOnlyInput">Readonly input </label>
                                                <input
                                                    class="form-control"
                                                    id="readOnlyInput"
                                                    type="text"
                                                    placeholder="Readonly input here..."
                                                    readonly
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a file input</h2>

                                            <div class="row gy-1">
                                                <div class="md:col-6">
                                                    <label for="formFileSm" class="form-label"
                                                        >Small file input example
                                                    </label>
                                                    <input
                                                        class="form-control form-control-sm"
                                                        id="formFileSm"
                                                        type="file"
                                                    />
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="formFile" class="form-label"
                                                        >Default file input example
                                                    </label>
                                                    <input class="form-control" type="file" id="formFile" />
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="formFileLg" class="form-label"
                                                        >Large file input example
                                                    </label>
                                                    <input
                                                        class="form-control form-control-lg"
                                                        id="formFileLg"
                                                        type="file"
                                                    />
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="formFileMultiple" class="form-label"
                                                        >Multiple files input example
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="file"
                                                        id="formFileMultiple"
                                                        multiple
                                                    />
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="formFileDisabled" class="form-label"
                                                        >Disabled file input example
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="file"
                                                        id="formFileDisabled"
                                                        disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="form-field" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Form field <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#form-field" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Form field Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="row g-1">
                                        <div class="md:col-6">
                                            <div class="form-field">
                                                <label for="formFieldEmail" class="form-label">E-mail</label>
                                                <input type="email" class="form-control" id="formFieldEmail" placeholder="nome@exemplo.com" />
                                                <div class="form-text">Nunca compartilharemos seu e-mail.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="form-adorn" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Form adorn <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#form-adorn" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Form adorn Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="row g-1">
                                        <div class="md:col-6">
                                            <label class="form-control form-adorn">
                                                <span class="form-adorn-text" aria-hidden="true">R$</span>
                                                <input type="text" class="form-ghost" placeholder="0,00" aria-label="Valor em reais" />
                                            </label>
                                        </div>
                                        <div class="md:col-6">
                                            <label class="form-control form-adorn">
                                                <input type="text" class="form-ghost" placeholder="seusite" aria-label="Domínio" />
                                                <span class="form-adorn-text" aria-hidden="true">.com.br</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="select" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Select
                                    <a href="#select" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Select">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row gy-block-small">
                                                <div class="md:col-6">
                                                    <label for="defaultSelect" class="form-label mt-1h"
                                                        >Example select
                                                    </label>
                                                    <select
                                                        class="form-control"
                                                        id="defaultSelect"
                                                        aria-label="Default select example"
                                                    >
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="multipleSelect" class="form-label mt-1h"
                                                        >Example multiple select
                                                    </label>
                                                    <select
                                                        class="form-control"
                                                        id="multipleSelect"
                                                        multiple
                                                        aria-label="Multiple select example"
                                                    >
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of sizing</h2>

                                            <div class="row gy-block-small">
                                                <div class="md:col-4">
                                                    <label class="col-form-label col-form-label-sm" for="selectDefault"
                                                        >Small select
                                                    </label>
                                                    <select
                                                        class="form-control form-control-sm"
                                                        aria-label="Small select example"
                                                    >
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-4">
                                                    <label class="col-form-label" for="selectDefault"
                                                        >Default select
                                                    </label>
                                                    <select
                                                        class="form-control"
                                                        id="selectDefault"
                                                        aria-label="Large select example"
                                                    >
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-4">
                                                    <label class="col-form-label col-form-label-lg" for="selectLarge"
                                                        >Large select
                                                    </label>
                                                    <select
                                                        class="form-control form-control-lg"
                                                        id="selectLarge"
                                                        aria-label="Large select example"
                                                    >
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled input</h2>

                                            <div>
                                                <label for="disabledSelect" class="form-label mt-1h"
                                                    >Disabled select
                                                </label>
                                                <select
                                                    class="form-control"
                                                    id="disabledSelect"
                                                    aria-label="Disabled select example"
                                                    disabled
                                                >
                                                    <option selected>Open this select menu</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="combobox" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Combobox <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#combobox" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Combobox Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="row g-1">
                                        <div class="md:col-4">
                                            <label class="form-label">Seleção simples</label>
                                            <div class="combobox position-relative">
                                                <input type="hidden" name="combobox-simple" value="" data-combobox-input />
                                                <button
                                                    type="button"
                                                    class="form-control combobox-toggle"
                                                    data-bs-toggle="combobox"
                                                    data-bs-placeholder="Selecione…"
                                                >
                                                    <span class="combobox-value">Selecione…</span>
                                                    <svg class="combobox-caret" width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M0.46967 5.46967C0.762563 5.17678 1.23744 5.17678 1.53033 5.46967L5 8.93934L8.46967 5.46967C8.76256 5.17678 9.23744 5.17678 9.53033 5.46967C9.82322 5.76256 9.82322 6.23744 9.53033 6.53033L5.53033 10.5303C5.23744 10.8232 4.76256 10.8232 4.46967 10.5303L0.46967 6.53033C0.176777 6.23744 0.176777 5.76256 0.46967 5.46967Z" fill="currentcolor" /></svg>
                                                </button>
                                                <div class="menu">
                                                    <button class="menu-item" type="button" data-bs-value="1">Opção um</button>
                                                    <button class="menu-item" type="button" data-bs-value="2">Opção dois</button>
                                                    <button class="menu-item" type="button" data-bs-value="3">Opção três</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="md:col-4">
                                            <label class="form-label">Com busca (substitui o tom-select)</label>
                                            <div class="combobox position-relative">
                                                <input type="hidden" name="combobox-search" value="" data-combobox-input />
                                                <button
                                                    type="button"
                                                    class="form-control combobox-toggle"
                                                    data-bs-toggle="combobox"
                                                    data-bs-placeholder="Selecione uma cidade…"
                                                    data-bs-search="true"
                                                >
                                                    <span class="combobox-value">Selecione uma cidade…</span>
                                                    <svg class="combobox-caret" width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M0.46967 5.46967C0.762563 5.17678 1.23744 5.17678 1.53033 5.46967L5 8.93934L8.46967 5.46967C8.76256 5.17678 9.23744 5.17678 9.53033 5.46967C9.82322 5.76256 9.82322 6.23744 9.53033 6.53033L5.53033 10.5303C5.23744 10.8232 4.76256 10.8232 4.46967 10.5303L0.46967 6.53033C0.176777 6.23744 0.176777 5.76256 0.46967 5.46967Z" fill="currentcolor" /></svg>
                                                </button>
                                                <div class="menu">
                                                    <div class="combobox-search">
                                                        <input type="text" class="form-control combobox-search-input" placeholder="Pesquisar…" autocomplete="off" aria-label="Pesquisar…" />
                                                    </div>
                                                    <button class="menu-item" type="button" data-bs-value="cps">Campinas</button>
                                                    <button class="menu-item" type="button" data-bs-value="rp">Ribeirão Preto</button>
                                                    <button class="menu-item" type="button" data-bs-value="sjrp">São José do Rio Preto</button>
                                                    <button class="menu-item" type="button" data-bs-value="sp">São Paulo</button>
                                                    <div class="combobox-no-results d-none">Não foi encontrando resultados</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="md:col-4">
                                            <label class="form-label">Múltipla escolha</label>
                                            <div class="combobox position-relative">
                                                <input type="hidden" name="combobox-multiple" value="laravel" data-combobox-input />
                                                <button
                                                    type="button"
                                                    class="form-control combobox-toggle"
                                                    data-bs-toggle="combobox"
                                                    data-bs-placeholder="Selecione as tags…"
                                                    data-bs-multiple="true"
                                                >
                                                    <span class="combobox-value">Selecione as tags…</span>
                                                    <svg class="combobox-caret" width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M0.46967 5.46967C0.762563 5.17678 1.23744 5.17678 1.53033 5.46967L5 8.93934L8.46967 5.46967C8.76256 5.17678 9.23744 5.17678 9.53033 5.46967C9.82322 5.76256 9.82322 6.23744 9.53033 6.53033L5.53033 10.5303C5.23744 10.8232 4.76256 10.8232 4.46967 10.5303L0.46967 6.53033C0.176777 6.23744 0.176777 5.76256 0.46967 5.46967Z" fill="currentcolor" /></svg>
                                                </button>
                                                <div class="menu">
                                                    <button class="menu-item selected" type="button" data-bs-value="laravel">Laravel</button>
                                                    <button class="menu-item" type="button" data-bs-value="livewire">Livewire</button>
                                                    <button class="menu-item" type="button" data-bs-value="bootstrap">Bootstrap</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="checks-radios" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Checkbox
                                    <a href="#checks-radios" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Checkbox">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="form-field">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    value=""
                                                    id="flexCheckDefault"
                                                />
                                                <label for="flexCheckDefault">
                                                    Default checkbox
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    value=""
                                                    id="flexCheckChecked"
                                                    checked
                                                />
                                                <label for="flexCheckChecked">
                                                    Checked checkbox
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled checkbox</h2>

                                            <div class="form-field">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    value=""
                                                    id="flexCheckDisabled"
                                                    disabled
                                                />
                                                <label for="flexCheckDisabled">
                                                    Disabled checkbox
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    value=""
                                                    id="flexCheckCheckedDisabled"
                                                    checked
                                                    disabled
                                                />
                                                <label for="flexCheckCheckedDisabled">
                                                    Disabled checked checkbox
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a radio</h2>

                                            <div class="form-field">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="flexRadioDefault"
                                                    id="flexRadioDefault1"
                                                />
                                                <label for="flexRadioDefault1">
                                                    Default radio
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="flexRadioDefault"
                                                    id="flexRadioDefault2"
                                                    checked
                                                />
                                                <label for="flexRadioDefault2">
                                                    Default checked radio
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled radio</h2>

                                            <div class="form-field">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="flexRadioDisabled"
                                                    id="flexRadioDisabled"
                                                    disabled
                                                />
                                                <label for="flexRadioDisabled">
                                                    Disabled radio
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="flexRadioDisabled"
                                                    id="flexRadioCheckedDisabled"
                                                    checked
                                                    disabled
                                                />
                                                <label for="flexRadioCheckedDisabled">
                                                    Disabled checked radio
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a switches</h2>

                                            <div class="form-field">
                                                <div class="switch">
                                                    <input
                                                    type="checkbox"
                                                    role="switch"
                                                    id="flexSwitchCheckDefault" switch
                                                />
                                                </div>
                                                <label for="flexSwitchCheckDefault">
                                                    Default switch checkbox input
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <div class="switch">
                                                    <input
                                                    type="checkbox"
                                                    role="switch"
                                                    id="flexSwitchCheckChecked"
                                                    checked switch
                                                />
                                                </div>
                                                <label for="flexSwitchCheckChecked">
                                                    Checked switch checkbox input
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <div class="switch">
                                                    <input
                                                    type="checkbox"
                                                    role="switch"
                                                    id="flexSwitchCheckDisabled"
                                                    disabled switch
                                                />
                                                </div>
                                                <label for="flexSwitchCheckDisabled">
                                                    Disabled switch checkbox input
                                                </label>
                                            </div>
                                            <div class="form-field">
                                                <div class="switch">
                                                    <input
                                                    type="checkbox"
                                                    role="switch"
                                                    id="flexSwitchCheckCheckedDisabled"
                                                    checked
                                                    disabled switch
                                                />
                                                </div>
                                                <label for="flexSwitchCheckCheckedDisabled">
                                                    Disabled checked switch checkbox input
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a inline checkbox</h2>

                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    id="inlineCheckbox1"
                                                    value="option1"
                                                />
                                                <label for="inlineCheckbox1">1 </label>
                                            </div>
                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    id="inlineCheckbox2"
                                                    value="option2"
                                                />
                                                <label for="inlineCheckbox2">2 </label>
                                            </div>
                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="check"
                                                    type="checkbox"
                                                    id="inlineCheckbox3"
                                                    value="option3"
                                                    disabled
                                                />
                                                <label for="inlineCheckbox3">3 (disabled) </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of inline radio</h2>

                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="inlineRadioOptions"
                                                    id="inlineRadio1"
                                                    value="option1"
                                                />
                                                <label for="inlineRadio1">1 </label>
                                            </div>
                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="inlineRadioOptions"
                                                    id="inlineRadio2"
                                                    value="option2"
                                                />
                                                <label for="inlineRadio2">2 </label>
                                            </div>
                                            <div class="form-field d-inline-grid me-1">
                                                <input
                                                    class="radio"
                                                    type="radio"
                                                    name="inlineRadioOptions"
                                                    id="inlineRadio3"
                                                    value="option3"
                                                    disabled
                                                />
                                                <label for="inlineRadio3">3 (disabled) </label>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of checkbox toggle buttons</h2>

                                            <label class="btn-check btn-solid theme-primary">
                                                <input type="checkbox" id="btn-check" autocomplete="off" />
                                                Single toggle
                                            </label>

                                            <label class="btn-check btn-solid theme-primary">
                                                <input
                                                type="checkbox"
                                                id="btn-check-2"
                                                checked
                                                autocomplete="off"
                                            />
                                                Checked
                                            </label>

                                            <label class="btn-check btn-solid theme-primary">
                                                <input
                                                type="checkbox"
                                                id="btn-check-3"
                                                autocomplete="off"
                                                disabled
                                            />
                                                Disabled
                                            </label>

                                            <label class="btn-check btn">
                                                <input type="checkbox" id="btn-check-4" autocomplete="off" />
                                                Single toggle
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="checkbox"
                                                id="btn-check-5"
                                                checked
                                                autocomplete="off"
                                            />
                                                Checked
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="checkbox"
                                                id="btn-check-6"
                                                autocomplete="off"
                                                disabled
                                            />
                                                Disabled
                                            </label>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of radio toggle buttons</h2>

                                            <label class="btn-check btn-solid theme-secondary">
                                                <input
                                                type="radio"
                                                name="options"
                                                id="option1"
                                                autocomplete="off"
                                                checked
                                            />
                                                Checked
                                            </label>

                                            <label class="btn-check btn-solid theme-secondary">
                                                <input
                                                type="radio"
                                                name="options"
                                                id="option2"
                                                autocomplete="off"
                                            />
                                                Radio
                                            </label>

                                            <label class="btn-check btn-solid theme-secondary">
                                                <input
                                                type="radio"
                                                name="options"
                                                id="option3"
                                                autocomplete="off"
                                                disabled
                                            />
                                                Disabled
                                            </label>

                                            <label class="btn-check btn-solid theme-secondary">
                                                <input
                                                type="radio"
                                                name="options"
                                                id="option4"
                                                autocomplete="off"
                                            />
                                                Radio
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="radio"
                                                name="options-base"
                                                id="option5"
                                                autocomplete="off"
                                                checked
                                            />
                                                Checked
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="radio"
                                                name="options-base"
                                                id="option6"
                                                autocomplete="off"
                                            />
                                                Radio
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="radio"
                                                name="options-base"
                                                id="option7"
                                                autocomplete="off"
                                                disabled
                                            />
                                                Disabled
                                            </label>

                                            <label class="btn-check btn">
                                                <input
                                                type="radio"
                                                name="options-base"
                                                id="option8"
                                                autocomplete="off"
                                            />
                                                Radio
                                            </label>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of outlined styles</h2>

                                            <label class="btn-check btn-outline theme-primary"
                                                >
                                                <input
                                                type="checkbox"
                                                id="btn-check-outlined"
                                                autocomplete="off"
                                            />
                                                Single toggle
                                            </label>

                                            <label class="btn-check btn-outline theme-secondary"
                                                >
                                                <input
                                                type="checkbox"
                                                id="btn-check-2-outlined"
                                                checked
                                                autocomplete="off"
                                            />
                                                Checked
                                            </label>

                                            <label class="btn-check btn-outline theme-success"
                                                >
                                                <input
                                                type="radio"
                                                name="options-outlined"
                                                id="success-outlined"
                                                autocomplete="off"
                                                checked
                                            />
                                                Checked success radio
                                            </label>

                                            <label class="btn-check btn-outline theme-danger"
                                                >
                                                <input
                                                type="radio"
                                                name="options-outlined"
                                                id="danger-outlined"
                                                autocomplete="off"
                                            />
                                                Danger radio
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="range" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Range
                                    <a href="#range" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Range">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <label for="customRange1" class="form-label">Example range </label>
                                            <div class="form-range">
                                                <input type="range" class="form-range-input" id="customRange1" />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled range</h2>

                                            <label for="disabledRange" class="form-label">Disabled range </label>
                                            <div class="form-range">
                                                <input type="range" class="form-range-input" id="disabledRange" disabled />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of min and max range</h2>

                                            <label for="customRange2" class="form-label">Example range </label>
                                            <div class="form-range">
                                                <input type="range" class="form-range-input" min="0" max="5" id="customRange2" />
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of steps range</h2>

                                            <label for="customRange3" class="form-label">Example range </label>
                                            <div class="form-range">
                                                <input
                                                type="range"
                                                class="form-range-input"
                                                min="0"
                                                max="5"
                                                step="0.5"
                                                id="customRange3"
                                            />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="input-group" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Input Group
                                    <a href="#input-group" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Input Group">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">@ </span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Username"
                                                aria-label="Username"
                                                aria-describedby="basic-addon1"
                                            />
                                        </div>

                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Recipient's username"
                                                aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                            />
                                            <span class="input-group-text" id="basic-addon2">
                                                @example
                                                .com
                                            </span>
                                        </div>

                                        <div>
                                            <label for="basic-url" class="form-label"> Your vanity URL </label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon3"
                                                    >https://example.com/users/
                                                </span>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="basic-url"
                                                    aria-describedby="basic-addon3 basic-addon4"
                                                />
                                            </div>
                                            <div class="form-text" id="basic-addon4">
                                                Example help text goes outside the input group.
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                aria-label="Amount (to the nearest dollar)"
                                            />
                                            <span class="input-group-text">.00</span>
                                        </div>

                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Username"
                                                aria-label="Username"
                                            />
                                            <span class="input-group-text">@</span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Server"
                                                aria-label="Server"
                                            />
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-text">With textarea</span>
                                            <textarea class="form-control" aria-label="With textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="floating-label" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Floating label
                                    <a href="#floating-label" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Floating label">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingInput">Email address</label>
                                                        <input
                                                            type="email"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="name@example.com"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingPassword">Password</label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id="floatingPassword"
                                                            placeholder="Password"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a textarea</h2>
                                            <div class="form-floating">
                                                <label for="floatingTextarea2">Comments</label>
                                                <textarea
                                                    class="form-control"
                                                    placeholder="Leave a comment here"
                                                    id="floatingTextarea2"
                                                ></textarea>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a select</h2>

                                            <div class="form-floating">
                                                <label for="floatingSelect">Works with selects</label>
                                                <select
                                                    class="form-control"
                                                    id="floatingSelect"
                                                    aria-label="Floating label select example"
                                                >
                                                    <option selected></option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a disabled</h2>

                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingInputDisabled">Email address</label>
                                                        <input
                                                            type="email"
                                                            class="form-control"
                                                            id="floatingInputDisabled"
                                                            placeholder="name@example.com"
                                                            disabled
                                                        />
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingTextareaDisabled">Comments</label>
                                                        <textarea
                                                            class="form-control"
                                                            placeholder="Leave a comment here"
                                                            id="floatingTextareaDisabled"
                                                            disabled
                                                        ></textarea>
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingTextarea2Disabled">Comments</label>
                                                        <textarea
                                                            class="form-control"
                                                            placeholder="Leave a comment here"
                                                            id="floatingTextarea2Disabled"
                                                            style="height: 100px"
                                                            disabled
                                                        >
Disabled textarea with some text inside</textarea>
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <div class="form-floating">
                                                        <label for="floatingSelectDisabled">Works with selects </label>
                                                        <select
                                                            class="form-control"
                                                            id="floatingSelectDisabled"
                                                            aria-label="Floating label disabled select example"
                                                            disabled
                                                        >
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="validation" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Validation
                                    <a href="#validation" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Validation">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <form class="needs-validation" novalidate>
                                            <div class="row g-1">
                                                <div class="md:col-4">
                                                    <label for="validationCustom01" class="form-label">First name </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="validationCustom01"
                                                        value="Mark"
                                                        required
                                                    />
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <div class="md:col-4">
                                                    <label for="validationCustom02" class="form-label">Last name </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="validationCustom02"
                                                        value="Otto"
                                                        required
                                                    />
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <div class="md:col-4">
                                                    <label for="validationCustomUsername" class="form-label"
                                                        >Username
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="inputGroupPrepend">@ </span>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="validationCustomUsername"
                                                            aria-describedby="inputGroupPrepend"
                                                            required
                                                        />
                                                        <div class="invalid-feedback input-group-ignore">Please choose a username.</div>
                                                    </div>
                                                </div>
                                                <div class="md:col-6">
                                                    <label for="validationCustom03" class="form-label">City </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="validationCustom03"
                                                        required
                                                    />
                                                    <div class="invalid-feedback">Please provide a valid city.</div>
                                                </div>
                                                <div class="md:col-3">
                                                    <label for="validationCustom04" class="form-label">State </label>
                                                    <select class="form-control" id="validationCustom04" required>
                                                        <option selected disabled value="">Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a valid state.</div>
                                                </div>
                                                <div class="md:col-3">
                                                    <label for="validationCustom05" class="form-label">Zip </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="validationCustom05"
                                                        required
                                                    />
                                                    <div class="invalid-feedback">Please provide a valid zip.</div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-field">
                                                        <input
                                                            class="check"
                                                            type="checkbox"
                                                            value=""
                                                            id="invalidCheck"
                                                            required
                                                        />
                                                        <label for="invalidCheck">
                                                            Agree to terms and conditions
                                                        </label>
                                                        <div class="invalid-feedback">
                                                            You must agree before submitting.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-solid theme-primary" type="submit">Submit form</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of invalid validation</h2>

                                            <form class="was-validated" data-bs-validate>
                                                <div class="row g-1">
                                                    <div class="col-12">
                                                        <label for="validationTextarea" class="form-label">Textarea </label>
                                                        <textarea
                                                            class="form-control"
                                                            id="validationTextarea"
                                                            placeholder="Required example textarea"
                                                            required
                                                        ></textarea>
                                                        <div class="invalid-feedback">
                                                            Please enter a message in the textarea.
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-field">
                                                            <input
                                                                type="checkbox"
                                                                class="check"
                                                                id="validationFormCheck1"
                                                                required
                                                            />
                                                            <label for="validationFormCheck1">
                                                                Check this checkbox
                                                            </label>
                                                            <div class="invalid-feedback">
                                                                Example invalid feedback text
                                                            </div>
                                                        </div>
                                                        <div class="form-field">
                                                            <input
                                                                type="radio"
                                                                class="radio"
                                                                id="validationFormCheck2"
                                                                name="radio-stacked"
                                                                required
                                                            />
                                                            <label for="validationFormCheck2">
                                                                Toggle this radio
                                                            </label>
                                                        </div>
                                                        <div class="form-field">
                                                            <input
                                                                type="radio"
                                                                class="radio"
                                                                id="validationFormCheck3"
                                                                name="radio-stacked"
                                                                required
                                                            />
                                                            <label for="validationFormCheck3">
                                                                Or toggle this other radio
                                                            </label>
                                                            <div class="invalid-feedback">
                                                                More example invalid feedback text
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="md:col-6">
                                                        <select class="form-control" required aria-label="select example">
                                                            <option value="">Open this select menu</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                        <div class="invalid-feedback">Example invalid select feedback</div>
                                                    </div>
                                                    <div class="md:col-6">
                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            aria-label="file example"
                                                            required
                                                        />
                                                        <div class="invalid-feedback">
                                                            Example invalid form file feedback
                                                        </div>
                                                    </div>
                                                    <div class="md:col-4">
                                                        <button class="btn btn-solid theme-primary" type="submit" disabled>
                                                            Submit form
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="search" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Search - Combobox
                                    <a href="#search" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Search - Combobox">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="position-relative">
                                            @php
                                                $developments = [

                                                    (object)[
                                                    'city' => 'São José do Rio Preto',
                                                    ],

                                                    (object)[
                                                    'city' => 'São José do Rio Preto',
                                                    'name' => 'Empreendimento 1',
                                                    ],

                                                    (object)[
                                                    'city' => 'São José do Rio Preto',
                                                    'name' => 'Empreendimento 2',
                                                    ],
                                                    ]
                                                @endphp
                                            <div class="combobox position-relative">
                                                <input type="hidden" name="search" value="" data-combobox-input wire:model.lazy="search" />
                                                <button
                                                    type="button"
                                                    class="form-control combobox-toggle ps-2hq form-control-lg @error('search-select') is-invalid @enderror"
                                                    data-bs-toggle="combobox"
                                                    data-bs-placeholder="Pesquisar"
                                                    data-bs-search="true"
                                                >
                                                    <span class="combobox-value">Pesquisar</span>
                                                    <svg class="combobox-caret" width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M0.46967 5.46967C0.762563 5.17678 1.23744 5.17678 1.53033 5.46967L5 8.93934L8.46967 5.46967C8.76256 5.17678 9.23744 5.17678 9.53033 5.46967C9.82322 5.76256 9.82322 6.23744 9.53033 6.53033L5.53033 10.5303C5.23744 10.8232 4.76256 10.8232 4.46967 10.5303L0.46967 6.53033C0.176777 6.23744 0.176777 5.76256 0.46967 5.46967Z" fill="currentcolor" /></svg>
                                                </button>
                                                <div class="menu">
                                                    <div class="combobox-search">
                                                        <input type="text" class="form-control combobox-search-input" placeholder="Pesquisar…" autocomplete="off" aria-label="Pesquisar…" />
                                                    </div>
                                                    @foreach (collect($developments)->sortBy(fn ($development) => $development->name ?? $development->city) as $development)
                                                        <button class="menu-item" type="button" data-bs-value="{{ $development->name ?? $development->city }}">
                                                            @isset($development->name)
                                                                <span class="menu-item-content">
                                                                    <span>{{ $development->name }}</span>
                                                                    <span class="menu-item-description">{{ $development->city }}</span>
                                                                </span>
                                                            @else
                                                                {{ $development->city }}
                                                            @endisset
                                                        </button>
                                                    @endforeach
                                                    <div class="combobox-no-results d-none">Não foi encontrando resultados</div>
                                                </div>
                                            </div>

                                            <x-icon
                                                name="frontend-ic-ui-search"
                                                class="ms-0hq fg-primary ic-xxsm position-absolute translate-middle-y start-0 top-50 z-1"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="datepicker" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Datepicker <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#datepicker" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Datepicker Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="row g-1">
                                        <div class="md:col-6">
                                            <label for="datepickerExample" class="form-label">Data</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="datepickerExample"
                                                data-bs-toggle="datepicker"
                                                autocomplete="off"
                                                placeholder="Escolha uma data…"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="chips" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Chips <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#chips" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Chips Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="hstack gap-1 flex-wrap">
                                            <span class="chip">Chip simples</span>
                                            <span class="chip">
                                                <x-frontend::image image="ratios/img-1x1.jpg" title="Imagem" alt="" class="chip-img" />
                                                Com imagem
                                            </span>
                                        </div>
                                        <div class="chip-input" data-bs-chips>
                                            <label class="chip-input-label" for="chipsInput">Tags:</label>
                                            <span class="chip">Laravel</span>
                                            <span class="chip">Bootstrap</span>
                                            <input type="text" class="form-ghost" id="chipsInput" placeholder="Adicionar…" />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="otp-input" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    OTP input <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#otp-input" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para OTP input Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="otp" data-bs-otp>
                                        <input type="text" class="otp-input" maxlength="6" aria-label="Código de verificação" />
                                    </div>
                                </div>
                            </section>

                            <section id="password-strength" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Password strength <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#password-strength" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Password strength Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="row g-1">
                                        <div class="md:col-6">
                                            <label for="passwordStrength" class="form-label">Senha</label>
                                            <input type="password" class="form-control" id="passwordStrength" placeholder="Digite uma senha" />
                                            <div class="strength" data-bs-strength>
                                                <div class="strength-segment"></div>
                                                <div class="strength-segment"></div>
                                                <div class="strength-segment"></div>
                                                <div class="strength-segment"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="livewire" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Livewire
                                    <a href="#livewire" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Livewire">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                                            <div class="row gx-1 gy-1h">
                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <label for="name" class="form-label">Seu nome </label>
                                                        <input
                                                            wire:model.lazy="name"
                                                            type="text"
                                                            id="name"
                                                            placeholder="Seu nome"
                                                            required
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
                                                        <label for="email" class="form-label">Seu e-mail </label>
                                                        <input
                                                            wire:model.lazy="email"
                                                            type="email"
                                                            id="email"
                                                            placeholder="Seu e-mail"
                                                            required
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
                                                        <label for="phone" class="form-label">Seu celular </label>
                                                        <input
                                                            wire:model.lazy="phone"
                                                            type="tel"
                                                            id="phone"
                                                            placeholder="Seu celular"
                                                            required
                                                            aria-label="telefone"
                                                            class="@error('phone') is-invalid @enderror js-mask-phone form-control"
                                                        />
                                                        @error('phone')
                                                            <span class="invalid-feedback"> {{ $message }} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="md:col-5 col-12">
                                                    <div class="form-floating">
                                                        <label for="state" class="form-label">Seu estado </label>
                                                        <select
                                                            wire:model.lazy="state"
                                                            id="state"
                                                            required
                                                            aria-label="estado"
                                                            class="@error('state') is-invalid @enderror form-control"
                                                        >
                                                            <option value=""></option>
                                                            @php $states = ['SP' => 'SP'] @endphp
                                                            @foreach ($states as $value => $text)
                                                                <option value="{{ $value }}">{{ $text }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('state')
                                                            <span class="invalid-feedback"> {{ $message }} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="md:col-7 col-12">
                                                    <div class="form-floating">
                                                        <label for="city" class="form-label">Sua cidade </label>
                                                        <select
                                                            wire:model.lazy="city"
                                                            id="city"
                                                            required
                                                            aria-label="city"
                                                            class="@error('city') is-invalid @enderror form-control"
                                                        >
                                                            <option value=""></option>
                                                            @php $cities = ['São Paulo' => 'São Paulo'] @endphp
                                                            @foreach ($cities as $value => $text)
                                                                <option value="{{ $value }}">{{ $text }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('city')
                                                            <span class="invalid-feedback"> {{ $message }} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <label for="message" class="form-label">Sua mensagem </label>
                                                        <textarea
                                                            wire:model.lazy="message"
                                                            id="message"
                                                            placeholder="Sua mensagem"
                                                            required
                                                            aria-label="mensagem"
                                                            rows="5"
                                                            class="@error('message') is-invalid @enderror form-control"
                                                        ></textarea>
                                                        @error('message')
                                                            <span class="invalid-feedback"> {{ $message }} </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-field">
                                                        <input
                                                            wire:model.lazy="terms"
                                                            type="checkbox"
                                                            name="privacy-terms"
                                                            required
                                                            class="check @error('terms') is-invalid @enderror"
                                                            id="privacy-terms"
                                                        />
                                                        <label class="fg-reset" for="privacy-terms">
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
                                                        aria-label="enviar formulário"
                                                        class="btn btn-solid theme-secondary w-100"
                                                    >
                                                        <span wire:loading.remove wire:target="submit">Enviar </span>
                                                        <span wire:loading wire:target="submit">
                                                            Enviando...
                                                            <span
                                                                class="spinner-grow spinner-sm ms-0h"
                                                                role="status"
                                                                aria-hidden="true"
                                                            ></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="hstack gap-0hq fs-small justify-content-center align-items-center mt-1">
                                                    <x-icon name="frontend-ic-shield" class="ic-xs" />
                                                    Seus dados estão seguros!
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div
                            class="vstack gap-block-small md:gap-block"
                        >
                            <section id="accessibility" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Accessibility
                                    <a href="#accessibility" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Accessibility">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <h2 class="fs-xlarge">Example of an image with a warning state</h2>

                                            <div class="hstack gap-0q">
                                                <div class="bg-danger" style="width: 20px; height: 20px"></div>
                                                <span> Missing <kbd>alt=""</kbd></span>
                                            </div>
                                            <div class="hstack gap-0q">
                                                <div class="bg-warning" style="width: 20px; height: 20px"></div>
                                                <span> Missing <kbd>loading=""</kbd></span>
                                            </div>
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of links with a warning state</h2>

                                            <div class="hstack gap-0q">
                                                <div class="bg-danger" style="width: 20px; height: 20px"></div>
                                                <span>Missing <kbd>aria-label=""</kbd></span>
                                            </div>
                                            <div class="hstack gap-0q">
                                                <div class="bg-warning" style="width: 20px; height: 20px"></div>
                                                <span>Missing <kbd>title=""</kbd></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="gallery" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Gallery
                                    <a href="#gallery" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Gallery">#</a>
                                </h2>
                                <div class="bd-example">
                                    <h2 class="fs-xlarge">Example of image gallery</h2>

                                    <div class="vstack gap-1">
                                        <div class="row g-1">
                                            <div class="md:col-6">
                                                <x-frontend::glightbox.image
                                                    description="descrição da imagem"
                                                    link="ratios/img-16x9-xl@2x.jpg"
                                                >
                                                    <x-frontend::picture
                                                        image="ratios/img-16x9.jpg"
                                                        title="imagem titulo"
                                                        alt="imagem alt"
                                                        pictureClass="ratio ratio-16x9"
                                                        class="img-cover"
                                                        has-breakpoints="true"
                                                        breakpointDesktopWidth="1400px"
                                                        breakpointDesktopSuffix="xl"
                                                        breakpointNotebookWidth="768px"
                                                        breakpointNotebookSuffix="lg"
                                                    />
                                                </x-frontend::glightbox.image>
                                            </div>
                                            <div class="md:col-6">
                                                <x-frontend::glightbox.image
                                                    description="descrição da imagem"
                                                    link="ratios/img-16x9-xl@2x.jpg"
                                                >
                                                    <x-frontend::picture
                                                        image="ratios/img-16x9.jpg"
                                                        title="imagem titulo"
                                                        alt="imagem alt"
                                                        pictureClass="ratio ratio-16x9"
                                                        class="img-cover"
                                                        has-breakpoints="true"
                                                        breakpointDesktopWidth="1400px"
                                                        breakpointDesktopSuffix="xl"
                                                        breakpointNotebookWidth="768px"
                                                        breakpointNotebookSuffix="lg"
                                                    />
                                                </x-frontend::glightbox.image>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="hover-lift" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Hover lift <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#hover-lift" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Hover lift Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                        <div class="row g-1">
                                        <div class="md:col-6">
                                            <div class="card hover-lift">
                                                <div class="card-body"><code>.hover-lift</code>: passe o mouse sobre o card.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="icons" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Icons
                                    <a href="#icons" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Icons">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            @php
                                                $icons = [
                                                    'ic-arrow-down',
                                                    'ic-arrow-right',
                                                    'ic-arrow-slider',
                                                    'ic-cup-coffee',
                                                    'ic-info',
                                                    'ic-information',
                                                    'ic-loading',
                                                    'ic-moon',
                                                    'ic-search',
                                                    'ic-share',
                                                    'ic-shield',
                                                    'ic-sun',
                                                    'ic-web-vitals-danger',
                                                    'ic-web-vitals-success',
                                                    'logo-fmd',
                                                    'logo-mdm',
                                                ];
                                            @endphp
                                            <div class="row">
                                                @foreach ($icons as $icon)
                                                    <div class="col-auto">
                                                        <div class="bs-component">
                                                            <x-icon name="frontend-{{ $icon }}" class="ic-xl" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="icon-link" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Icon link
                                    <a href="#icon-link" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Icon link">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <x-frontend::link
                                                link="#"
                                                label="Compartilhar"
                                                icon="ic-share"
                                                class="btn btn-solid theme-primary"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a link icon with an inverted icon</h2>

                                            <x-frontend::link
                                                link="#"
                                                label="Ver mais"
                                                icon="ic-arrow-right"
                                                icon-change-position="true"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a link icon with an animated icon</h2>

                                            <x-frontend::link
                                                link="#"
                                                label="Compartilhar"
                                                icon="ic-share"
                                                class="btn btn-solid theme-primary icon-link-hover-scale-center"
                                            />

                                            <x-frontend::link
                                                link="#"
                                                label="Ver mais"
                                                icon="ic-arrow-right"
                                                icon-change-position="true"
                                            />

                                            <x-frontend::link
                                                link="#"
                                                label="Ver mais"
                                                icon="ic-info"
                                                icon-change-position="true"
                                                class="btn btn-solid theme-primary icon-link-hover-flip-horizontal"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="list-icon" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    List icon
                                    <a href="#list-icon" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para List icon">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <h2 class="fs-xlarge">Example of a list icon component with icon</h2>

                                            <x-frontend::list-icon
                                                sanitizeList
                                                icon-class="ic-xxsm fg-primary"
                                                class="vstack gap-0h mb-0"
                                                :content="[(object)['icon'=>'ic-differential', 'text'=> 'Descrição da lista'],
                                                        (object)['icon'=>'ic-differential', 'text'=> 'Descrição da lista']]"
                                            />
                                        </div>

                                        <div>
                                            <hr />
                                            <h2 class="fs-xlarge">Example of a list icon component without icon</h2>

                                            <x-frontend::list-icon
                                                sanitizeList
                                                class="vstack gap-0h mb-0"
                                                :content="[(object)['text'=> 'Descrição da lista'],
                                                        (object)['text'=> 'Descrição da lista']]"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="infinite-scroll" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Infinite scroll
                                    <a href="#infinite-scroll" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Infinite scroll">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="page-load-status mx-auto">
                                            <div class="infinite-scroll-request fg-primary text-center">
                                                <x-icon
                                                    name="frontend-ic-loading"
                                                    class="animation-spin-right ic-xl fg-primary"
                                                />
                                            </div>
                                            <p class="infinite-scroll-last"></p>
                                            <p class="infinite-scroll-error"></p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="pwa-icons" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Pwa icons
                                    <a href="#pwa-icons" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Pwa icons">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div>
                                            <div class="row g-1">
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="logo.png"
                                                            is-single-image="true"
                                                            title="200x70 - logo.png"
                                                            alt="200x70 - logo.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 200x70 - logo.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="logo-email.png"
                                                            is-single-image="true"
                                                            title="200x70 - logo-email.png"
                                                            alt="200x70 - logo-email.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 200x70 - logo-email.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/favicon.ico"
                                                            width="48"
                                                            height="48"
                                                            is-single-image="true"
                                                            title="48x48 - favicon.ico"
                                                            alt="48x48 - favicon.ico"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 48x48 - favicon.ico </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="logo-amp.png"
                                                            is-single-image="true"
                                                            title="60x60 - logo-amp.png"
                                                            alt="60x60 - logo-amp.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 60x60 - logo-amp.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/mstile-150x150.png"
                                                            is-single-image="true"
                                                            title="150x150 - mstile-150x150.png"
                                                            alt="150x150 - mstile-150x150.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 150x150 - mstile-150x150.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/safari-pinned-tab.svg"
                                                            width="512"
                                                            height="512"
                                                            is-single-image="true"
                                                            title="512x512 - safari-pinned-tab.svg"
                                                            alt="512x512 - safari-pinned-tab.svg"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 512x512 - safari-pinned-tab.svg </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/apple-touch-icon.png"
                                                            is-single-image="true"
                                                            title="180x180 - apple-touch-icon.png"
                                                            alt="180x180 - apple-touch-icon.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 180x180 - apple-touch-icon.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/icon-192x192.png"
                                                            is-single-image="true"
                                                            title="192x192 - icon-192x192.png"
                                                            alt="192x192 - icon-192x192.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 192x192 - icon-192x192.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                                <div class="md:col-6">
                                                    <x-frontend::cards.card card-body-class="vstack bd-example-code align-items-center gap-1">
                                                        <x-frontend::image
                                                            image="icons/icon-512x512.png"
                                                            is-single-image="true"
                                                            title="512x512 - icon-512x512.png"
                                                            alt="512x512 - icon-512x512.png"
                                                            class="img-sanitize"
                                                        />
                                                        <small class="text-center"> 512x512 - icon-512x512.png </small>
                                                    </x-frontend::cards.card>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="text-balance" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Text balance <span class="badge badge-subtle theme-success fs-xsmall">Novo</span>
                                    <a href="#text-balance" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Text balance Novo">#</a>
                                </h2>
                                <div class="bd-example">
                                        <div class="row g-1">
                                        <div class="md:col-6">
                                            <p class="text-balance mb-0">
                                                <code>.text-balance</code> equilibra as linhas de títulos e textos curtos para evitar palavras
                                                sozinhas na última linha.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="video" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Vídeo
                                    <a href="#video" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Vídeo">#</a>
                                </h2>
                                <div class="bd-example">
                                    <div class="vstack gap-1">
                                        <div class="row g-1">
                                            <div class="md:col-6">
                                                <h2 class="fs-xlarge">Modal video example</h2>
                                                <x-frontend::glightbox.video link="https://youtu.be/lG7o0r-7coo?si=a8uCcwaD_hsqgQM3">
                                                    <x-frontend::picture
                                                        image="ratios/img-16x9.jpg"
                                                        title="imagem titulo"
                                                        alt="imagem alt"
                                                        pictureClass="ratio ratio-16x9"
                                                        class="img-cover"
                                                        has-breakpoints="true"
                                                        breakpointDesktopWidth="1400px"
                                                        breakpointDesktopSuffix="xl"
                                                        breakpointNotebookWidth="768px"
                                                        breakpointNotebookSuffix="lg"
                                                    />
                                                </x-frontend::glightbox.video>
                                            </div>

                                            <div class="md:col-6">
                                                <h2 class="fs-xlarge">Embedded video example</h2>
                                                <x-frontend::glightbox.player-embed
                                                    id="about-us-video"
                                                    link="https://youtu.be/lG7o0r-7coo?si=a8uCcwaD_hsqgQM3"
                                                    image="ratios/img-16x9.jpg"
                                                    class="img-cover"
                                                    title="imagem titulo"
                                                    alt="imagem alt"
                                                    aspect-ratio="-h-100 ratio ratio-1x1 md:ratio-16x9"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="slider" class="bd-section vstack gap-1">
                                <h2 class="h4 mb-0 hstack align-items-center gap-0h">
                                    Slider
                                    <a href="#slider" class="bd-anchor fg-2 text-decoration-none" aria-label="Link para Slider">#</a>
                                </h2>
                                <div class="bd-example">

                                    <div class="vstack gap-1">
                                        <div>
                                            <h2 class="fs-xlarge">Example of a slider banner</h2>

                                            <div>
                                                @php
                                                    $banners = [

                                                        (object) [
                                                            'content' => (object) [
                                                                'name' => 'Titulo do banner',
                                                                'subtitle' => 'Subtitulo do banner',
                                                                'route' => '/html/#',
                                                                'details' => [
                                                                    (object) ['icon' => 'ic-differential', 'text' => '100 a 200m²'],
                                                                    (object) ['icon' => 'ic-differential', 'text' => '1 ou 2 dorms. (1 suíte)'],
                                                                ],
                                                            ],

                                                            'image' => (object) [
                                                                'src' => 'ratios/img-21x9.jpg',
                                                                'name' => 'Imagem 21x9',
                                                            ],
                                                        ],

                                                        (object) [
                                                            'content' => (object) [
                                                                'name' => 'Titulo do banner 2',
                                                                'subtitle' => 'Subtitulo do banner 2',
                                                                'route' => '/html/#',
                                                                'details' => [
                                                                    (object) ['icon' => 'ic-differential', 'text' => '100 a 200m²'],
                                                                    (object) ['icon' => 'ic-differential', 'text' => '1 ou 2 dorms. (1 suíte)'],
                                                                ],
                                                            ],

                                                            'image' => (object) [
                                                                'src' => 'ratios/img-21x9.jpg',
                                                                'name' => 'Imagem 21x9',
                                                            ],
                                                        ],

                                                        (object) [
                                                            'content' => false,

                                                            'image' => (object) [
                                                                'src' => 'ratios/img-21x9.jpg',
                                                                'name' => 'Imagem 21x9',
                                                            ],
                                                        ],

                                                    ];
                                                @endphp

                                                <x-frontend::sliders.banner :banners="$banners" :priority="false" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('footer')
    <x-frontend::dialogs.dialog-base></x-frontend::dialogs.dialog-base>
@endpush

@section('footer') @endsection

@push('scripts')
    @vite('resources/js/pages/theme.js')

@endpush
