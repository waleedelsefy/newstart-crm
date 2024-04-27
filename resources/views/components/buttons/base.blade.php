@props(['text', 'href' => '', 'icon' => ''])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['btn']) }}>

        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif

        {{ $text }}
    </a>
@else
    <button {{ $attributes->class(['btn']) }}>

        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif

        {{ $text }}
    </button>
@endif
