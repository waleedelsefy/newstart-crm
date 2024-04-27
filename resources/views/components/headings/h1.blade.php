@props(['notes' => ''])


@if ($notes)
    <div {{ $attributes->class(['head-notes', 'h1-head-notes']) }}>
        <h1>{{ $slot }}</h1>
        <p>{{ $notes }}</p>
    </div>
@else
    <h1 {{ $attributes->class([]) }}>{{ $slot }}</h1>
@endif
