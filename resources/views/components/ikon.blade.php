@props(['nama'])

<svg {{ $attributes->merge(['class' => 'ikon-svg']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($nama)
        @case('buku')
            <path d="M2 4h7a3 3 0 0 1 3 3v13a2 2 0 0 0-2-2H2z"/><path d="M22 4h-7a3 3 0 0 0-3 3v13a2 2 0 0 1 2-2h8z"/>
            @break
        @case('menu')
            <path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>
            @break
        @case('chevron')
            <path d="M6 9l6 6 6-6"/>
            @break
    @endswitch
</svg>