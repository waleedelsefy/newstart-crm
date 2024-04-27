@props(['name', 'id' => '', 'value' => '', 'label' => '', 'error_bag' => 'default', 'icon' => 'feather icon-check'])

<x-form.group :name="$name" id="{{ $id ? $id : $name }}" :error_bag="$error_bag">

    <div class="vs-checkbox-con vs-checkbox-primary">
        <input {{ $attributes->class([]) }} type="checkbox" name="{{ $name }}"
            {{ $value ? " value=$value" : '' }}>
        <span class="vs-checkbox">
            <span class="vs-checkbox--check">
                <i class="vs-icon {{ $icon }}"></i>
            </span>
        </span>
        <span>{{ $label }}</span>
    </div>

</x-form.group>
