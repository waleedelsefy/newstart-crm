@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h4-head-notes']) }}>
        <h4>{{ $slot }}</h4>
        <p>{{ $notes }}</p>
    </div>
@else
    <h4 {{ $attributes->class([]) }}>{{ $slot }}</h4>
@endif
