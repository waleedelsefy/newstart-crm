@props(['text', 'icon' => ''])

<x-badges.base :text="$text" :icon="$icon" {{ $attributes->class(['badge-success']) }} />
