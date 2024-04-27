@props(['name', 'label' => '', 'value' => '1', 'checked' => false, 'id' => '', 'error_bag' => 'default'])

@php
    $id = $id == '' ? $name : $id;
@endphp

<div {{ $attributes->class(['custom-control custom-switch custom-control-inline']) }}>
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" class="custom-control-input"
        id="{{ $id }}" @checked($checked)>
    <label class="custom-control-label" for="{{ $id }}"></label>
    <span class="switch-label">{{ $label }}</span>
</div>

<x-form.error :name="$name" :error_bag="$error_bag" />
