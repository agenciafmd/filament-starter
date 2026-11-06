<!doctype html>
<html lang="{{ strtolower(str_replace('_', '-', app()->getLocale())) }}">
<head>
    <x-filament-settings::gtm-head />
    <x-filament-settings::google-analytics />
    <x-filament-settings::meta-pixel />

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (config('app.env') !== 'production')
        <meta name="robots" content="noindex,nofollow" />
        <meta name="googlebot" content="noindex,nofollow" />
    @else
        <script>
            console.log = function () {};
        </script>
    @endif
    <x-social-meta
        title="{{ $__env->yieldContent('title', 'A cultura come a estratégia no café da manhã') }} | {{ config('app.name') }}"
        description="{{ $__env->yieldContent('description') }}"
    />
    <x-frontend::pwa />
    <x-frontend::fonts-preload />
    <x-filament-settings::site-verification />
    <x-frontend::critical-css :$critical stylesheet="resources/scss/frontend.scss" />

    <livewire:styles />

    @stack('head')

    <x-filament-settings::header-scripts />
</head>
<body class="{{ ($bodyClass) ?? '' }}">
    <x-filament-settings::gtm-body />

    @stack('header')

    @yield('header', view('frontend::partials.header'))

    @yield('content')

    @yield('footer', view('frontend::partials.footer'))

    @stack('footer')

    @vite('resources/js/frontend-imports.js')

    <livewire:scripts />

    @include('frontend::partials.message')

    @stack('scripts')

    <x-filament-settings::footer-scripts />

    {{--
@if(config('app.env') !== 'local')
<script>
    pwaManager();
</script>
@endif
--}}
</body>
</html>
