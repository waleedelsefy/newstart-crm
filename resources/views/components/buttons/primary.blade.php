@props(['text', 'href' => '', 'icon' => ''])

<x-buttons.base :href="$href" :text="$text" :icon="$icon" {{ $attributes->class(['btn-primary']) }} />
