@props(['name', 'error_bag' => 'default'])

@php
    // if name is like categories[en] convert to categories.en
    if (str_ends_with($name, ']')) {
        $name = str_replace('[', '.', str_replace(']', '', $name));
    }
@endphp

@error($name, $error_bag)
    <small {{ $attributes->class(['text-danger d-block']) }}>{{ $message }}</small>
@enderror
