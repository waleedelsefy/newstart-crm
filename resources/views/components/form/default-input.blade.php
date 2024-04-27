@props(['name', 'id' => '', 'type' => 'text', 'value' => '', 'placeholder' => '', 'error_bag' => 'default'])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id ?? $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->getBag($error_bag)->has($name)]) }}
    placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">
