{{-- fonte externa: gerada pelo vite-plugin-webfont-dl a partir da lista `webfonts` do vite.config.js --}}
{{-- usando só fonte local (resources/scss/frontend/_fonts.scss), esvazie `webfonts` e remova esta linha, --}}
{{-- senão o Laravel não encontra o webfonts.css no manifest --}}
@vite('webfonts.css')

{{-- exemplo de importação de fontes externas --}}
{{--<link rel="preconnect"--}}
{{--      href="https://use.typekit.net">--}}
{{--<link href="https://use.typekit.net/jkg4xth.css"--}}
{{--      rel="stylesheet">--}}

{{-- exemplo de importação de fontes locais --}}
{{--<link rel="preload"--}}
{{--      href="{{ Vite::font('Roboto-Light.woff2') }}"--}}
{{--      as="font"--}}
{{--      type="font/woff2"--}}
{{--      crossorigin>--}}
