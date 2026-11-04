<!-- PWA Configuration -->
{{-- `theme_color` vem dos tokens do tema, gravado no manifest pelo build (`resources/js/utilities/create-manifest.js`) --}}
@php
    $themeColor = '#ffffff';
@endphp
@if (file_exists(public_path('manifest.json')))
    @php
        $themeColor = json_decode(file_get_contents(public_path('manifest.json')), true)['theme_color'] ?? $themeColor;
    @endphp
    <link rel="manifest" href="{{ asset('/manifest.json') }}" />
@endif
<link rel="apple-touch-icon" sizes="192x192" href="{{ Vite::image('icons/apple-touch-icon.png') }}" />
<link rel="shortcut icon" href="{{ Vite::image('icons/favicon.ico') }}" type="image/x-icon" />
<link rel="mask-icon" href="{{ Vite::image('icons/safari-pinned-tab.svg') }}" color="{{ $themeColor }}" />
<meta name="msapplication-TileColor" content="{{ $themeColor }}" />
<meta name="theme-color" content="{{ $themeColor }}" />

<!-- IOS -->
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<!-- End PWA Configuration -->
