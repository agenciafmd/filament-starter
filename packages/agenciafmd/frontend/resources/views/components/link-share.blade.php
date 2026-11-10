@props([
    'shareClass' => false,
])
<x-frontend::link
    href="#"
    label="Compartilhe"
    role="button"
    data-fmd-share-btn-fbidentification=""
    title="Compartilhe"
    aria-label="Link para compartilhar"
    iconChangePosition
    icon="ic-ui-arrow-right"
    class="btn btn-solid theme-primary btn-lg justify-content-center w-100 js-btn-share {{ $shareClass }}"
/>

@pushOnce('scripts')
    @vite('resources/js/components/share-api.js')
@endPushOnce
