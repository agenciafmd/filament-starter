@props([
'isColumn' => false,
'contentClass' => '',
'iconClass' => false,
'socialRow' => false,
'socialNetworksList' => null, // Parâmetro opcional para filtrar redes sociais
])
<div class="gap-1 {{ ($isColumn ? 'vstack' : 'hstack' ) }} {{ $contentClass }}">
  @php
  $socialNetworks = [
  [
  'icon' => 'ic-social-facebook',
  'link' => '#',
  'title' => 'Contato via Facebook',
  ],
  [
  'icon' => 'ic-social-linkedin',
  'link' => '#',
  'title' => 'Contato via Linkedin',
  ],
  [
  'icon' => 'ic-social-youtube',
  'link' => '#',
  'title' => 'Contato via Youtube',
  ],
  [
  'icon' => 'ic-social-instagram',
  'link' => '#',
  'title' => 'Contato via Instagram',
  ],
  [
  'icon' => 'ic-social-tiktok',
  'link' => '#',
  'title' => 'Contato via Tiktok',
  ],
  ];

  // Se o parâmetro 'socialNetworksList' for passado, filtra as redes sociais
  if ($socialNetworksList) {
  $socialNetworks = array_filter($socialNetworks, function ($network) use
  ($socialNetworksList) {
  return in_array($network['icon'], $socialNetworksList);
  });
  }
  @endphp

  @foreach($socialNetworks as $socialNetwork)

  @if(!$loop->first && $socialRow)
  <span class="vr w-border-sm text-gray-500"></span>
  @endif

  <x-frontend::link link="{{ $socialNetwork['link'] }}"
                    :is-extern="true"
                    aria-label="{{ $socialNetwork['title'] }}"
                    title="{{ $socialNetwork['title'] }}"
                    {{ $attributes }}>
    <x-frontend-icon class="{{ $iconClass }}"
                     name="{{ $socialNetwork['icon']  }}"/>
  </x-frontend::link>

  @endforeach
</div>