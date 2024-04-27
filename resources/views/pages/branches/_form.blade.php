@csrf

@if ($branch->name)
    @method('PUT')
@endif



<div class="row">

    @foreach (config('laravellocalization.supportedLocales') as $locale => $options)
        <div class="col-lg-6">
            @php
                $branchName = $branch->name ? $branch->getTranslations('name')[$locale] : '';
                $inputLabel = __('Name In ' . $options['name']);
                $inputName = "name[$locale]";
            @endphp

            <x-form.input :floating_group="true" :name="$inputName" :placeholder="$inputLabel" :label="$inputLabel" :value="$branchName" />
        </div>
    @endforeach


    <div class="col-lg-12">
        <x-form.input :floating_group="true" name="address" placeholder="{{ __('Address') }}" label="{{ __('Address') }}"
            :value="$branch->address" />
    </div>

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$branch->description" cols="30" rows="4" />
    </div>

    <div class="col-lg-6">
        <x-form.select :select2="true" name="status" label="{{ __('Status') }}">
            @foreach ($availableStatus as $key => $val)
                <option value="{{ $key }}" @selected(old('status', Str::slug($branch->status)) == $key)>{{ __($val) }}
                </option>
            @endforeach
        </x-form.select>
    </div>
</div>

@if ($branch->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
