@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h3-head-notes']) }}>
        <h3>{{ $slot }}</h3>
        <p>{{ $notes }}</p>
    </div>
@else
    <h3 {{ $attributes->class([]) }}>{{ $slot }}</h3>
@endif
