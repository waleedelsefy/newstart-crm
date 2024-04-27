@csrf

@if ($permission->name)
    @method('PUT')
@endif



<div class="row">
    <div class="col-lg-6">
        <x-form.input :floating_group="true" name="module" placeholder="{{ __('Module') }}" label="{{ __('Module') }}"
            :value="$permission->module" />
    </div>

    <div class="col-lg-6">
        <x-form.input :floating_group="true" name="name" placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
            :value="$permission->name" />
    </div>

    @foreach (config('laravellocalization.supportedLocales') as $locale => $options)
        <div class="col-lg-6">
            @php
                $permissionDisplayName = $permission->display_name ? $permission->getTranslations('display_name')[$locale] : '';
                $inputLabel = __('Display Name In ' . $options['name']);
                $inputName = "display_name[$locale]";
            @endphp

            <x-form.input :floating_group="true" :name="$inputName" :placeholder="$inputLabel" :label="$inputLabel" :value="$permissionDisplayName" />
        </div>
    @endforeach

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$permission->description" cols="30" rows="4" />
    </div>
</div>

@if ($permission->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
