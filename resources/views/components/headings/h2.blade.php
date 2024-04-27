@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h2-head-notes']) }}>
        <h2>{{ $slot }}</h2>
        <p>{{ $notes }}</p>
    </div>
@else
    <h2 {{ $attributes->class([]) }}>{{ $slot }}</h2>
@endif
