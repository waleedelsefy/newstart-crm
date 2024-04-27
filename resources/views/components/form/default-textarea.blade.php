@props(['name', 'id' => '', 'value' => '', 'placeholder' => '', 'error_bag' => 'default'])


<textarea name="{{ $name }}" id="{{ $id ?? $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->getBag($error_bag)->has($name)]) }}
    placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
