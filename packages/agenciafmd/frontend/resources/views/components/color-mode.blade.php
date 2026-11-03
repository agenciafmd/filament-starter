{{--
    Aplica o tema antes do CSS carregar, para não piscar o tema claro.
    Usa a escolha salva pelo botão de tema (resources/js/components/color-mode.js) ou, sem escolha, o tema do sistema.
--}}
<script>
    (function () {
        let theme = null;

        try {
            theme = localStorage.getItem('theme');
        } catch (error) {}

        if (theme !== 'light' && theme !== 'dark') {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        document.documentElement.setAttribute('data-bs-theme', theme);
    })();
</script>
