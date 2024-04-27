@props([
    'floating_group' => false,
    'name',
    'id' => '',
    'type' => 'text',
    'value' => '',
    'label' => '',
    'placeholder' => '',
    'error_bag' => 'default',
    'icon' => '',
])

@if ($floating_group)
    <x-form.floating-group :name="$name" id="{{ $id ? $id : $name }}" :label="$label" :error_bag="$error_bag"
        :icon="$icon">
        <x-form.default-input :type="$type" :name="$name" id="{{ $id ? $id : $name }}" :placeholder="$placeholder"
            :value="$value" :error_bag="$error_bag" {{ $attributes->class([]) }} />
    </x-form.floating-group>
@else
    <x-form.group :name="$name" id="{{ $id ? $id : $name }}" :label="$label" :error_bag="$error_bag">
        <x-form.default-input :type="$type" :name="$name" id="{{ $id ? $id : $name }}" :placeholder="$placeholder"
            :value="$value" :error_bag="$error_bag" {{ $attributes->class([]) }} />
    </x-form.group>
@endif
