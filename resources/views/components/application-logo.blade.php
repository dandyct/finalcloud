@props(['class' => ''])

<!-- Pequeño SVG para evitar logo gigante -->
<svg {{ $attributes->merge(['class' => 'me-2']) }} width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="logo">
    <rect width="24" height="24" rx="4" fill="#1E88E5"></rect>
    <path d="M6 9L11 14L18 7" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>