@csrf

@if ($role->name)
    @method('PUT')
@endif



<div class="row">
    <div class="col-lg-12">
        <x-form.input :floating_group="true" name="name" placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
            :value="$role->name" />
    </div>

    @foreach (config('laravellocalization.supportedLocales') as $locale => $options)
        <div class="col-lg-6">
            @php
                $roleDisplayName = $role->display_name ? $role->getTranslations('display_name')[$locale] : '';
                $inputLabel = __('Display Name In ' . $options['name']);
                $inputName = "display_name[$locale]";
            @endphp

            <x-form.input :floating_group="true" :name="$inputName" :placeholder="$inputLabel" :label="$inputLabel" :value="$roleDisplayName" />
        </div>
    @endforeach

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$role->description" cols="30" rows="4" />
    </div>


    <div class="col-12">
        <x-headings.h4 class="mb-2">
            {{ __('Permissions') }}
        </x-headings.h4>

        <div class="accordion" id="accordionExample" data-toggle-hover="true">
            @foreach ($permissions as $module => $module_permissions)
                @php
                    $moduleUniquPrefix = Illuminate\Support\Str::slug($module);
                @endphp

                <div class="collapse-margin">
                    <div class="card-header" id="permissions-{{ $moduleUniquPrefix }}" data-toggle="collapse"
                        role="button" data-target="#permissions-{{ $moduleUniquPrefix }}-acc" aria-expanded="false"
                        aria-controls="permissions-{{ $moduleUniquPrefix }}-acc">
                        <span class="lead collapse-title collapsed">
                            {{ __(ucwords($module)) }}
                        </span>
                    </div>
                    <div id="permissions-{{ $moduleUniquPrefix }}-acc" class="collapse"
                        aria-labelledby="permissions-{{ $moduleUniquPrefix }}" data-parent="#accordionExample">
                        <div class="card-body">

                            <x-form.permissions-switches name="permissions[]" :permissions="$module_permissions" :checked_permissions="$role_permissions ?? []" />

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@if ($role->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
