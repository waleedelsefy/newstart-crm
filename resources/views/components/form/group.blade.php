@props(['name', 'id' => '', 'label' => '', '', 'error_bag' => ''])

<div {{ $attributes->class(['form-group']) }}>
    @if ($label)
        <x-form.label :id="$id" :label="$label" />
    @endif

    {{ $slot }}

    <x-form.error :name="$name" :error_bag="$error_bag" />
</div>
