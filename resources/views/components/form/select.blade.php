@props(['name', 'id' => '', 'label' => '', 'select2' => false, 'error_bag' => 'default'])

<x-form.group :name="$name" id="{{ $id ? $id : $name }}" :label="$label" :error_bag="$error_bag">

    <select name="{{ $name }}" id="{{ $id ?? $name }}"
        {{ $attributes->class(['select2' => $select2, 'form-control', 'is-invalid' => $errors->getBag($error_bag)->has($name)]) }}>
        {{ $slot }}
    </select>

</x-form.group>
