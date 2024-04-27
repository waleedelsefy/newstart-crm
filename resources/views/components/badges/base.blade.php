@props(['text', 'icon' => ''])

<div {{ $attributes->class(['badge']) }}>
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span>{{ $text }}</span>
</div>
