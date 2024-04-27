@props(['name', 'id' => '', 'label' => '', 'error_bag' => 'default', 'icon' => ''])


<fieldset {{ $attributes->class(['form-label-group', 'position-relative', 'has-icon-left' => $icon]) }}>
    {{ $slot }}

    @if ($icon)
        <div class="form-control-position">
            <i class="{{ $icon }}"></i>
        </div>
    @endif

    @if ($label)
        <x-form.label :id="$id" :label="$label" />
    @endif

    <x-form.error :name="$name" :error_bag="$error_bag" />
</fieldset>
