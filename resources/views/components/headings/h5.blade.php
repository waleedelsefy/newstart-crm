@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h5-head-notes']) }}>
        <h5>{{ $slot }}</h5>
        <p>{{ $notes }}</p>
    </div>
@else
    <h5 {{ $attributes->class([]) }}>{{ $slot }}</h5>
@endif
