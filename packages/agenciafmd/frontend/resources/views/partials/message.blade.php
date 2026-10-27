@php
    $alerts = collect(session('flash_notification', collect())->toArray())
        ->map(fn (array $message): array => [
            'level' => $message['level'],
            'message' => $message['message'],
        ]);

    if ($alerts->isEmpty() && session('errors')?->has('hp_time')) {
        $alerts->push([
            'level' => 'info',
            'message' => 'Por favor, aguarde alguns segundos para enviar os dados.',
        ]);
    }

    session()->forget('flash_notification');
@endphp

{{--
    type="module": scripts de módulo rodam na ordem do documento, depois do @vite('resources/js/frontend-imports.js'),
    então o window.Swal já existe quando os alertas são disparados.
--}}
<script type="module">
    const alertTypes = {
        success: { icon: 'success', title: 'Sucesso' },
        danger: { icon: 'error', title: 'Falhou!' },
        warning: { icon: 'warning', title: 'Atenção' },
        info: { icon: 'info', title: 'Informação' },
    };

    function showAlert({ level, message }) {
        const { icon, title } = alertTypes[level] ?? alertTypes.info;

        Swal.fire({
            text: message,
            icon,
            title,
            showConfirmButton: false,
            showCloseButton: true,
        });
    }

    @js($alerts->values())
        .forEach(showAlert);

    document.addEventListener('livewire:init', () => {
        Livewire.on('swal', (param) => {
            showAlert(param);
        });

        Livewire.on('datalayer', (param) => {
            const defaultDataLayerOptions = {
                event: param.event || 'form',
                action: param.action || 'success',
                details: param.message || 'Formulário Disparado!',
                form_name: param.form_name || 'Contato',
                form_id: param.form_id || '00000',
            };

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                ...defaultDataLayerOptions,
                ...param,
            });
        });
    });
</script>
