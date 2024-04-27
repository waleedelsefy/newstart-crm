@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h6-head-notes']) }}>
        <h6>{{ $slot }}</h6>
        <p>{{ $notes }}</p>
    </div>
@else
    <h6 {{ $attributes->class([]) }}>{{ $slot }}</h6>
@endif
