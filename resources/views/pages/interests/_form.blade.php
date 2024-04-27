@csrf

@if ($interest->name)
    @method('PUT')
@endif



<div class="row">
    @foreach (config('laravellocalization.supportedLocales') as $locale => $options)
        <div class="col-lg-6">
            @php
                $interestName = $interest->name ? $interest->getTranslations('name')[$locale] : '';
                $inputLabel = __('Name In ' . $options['name']);
                $inputName = "name[$locale]";
            @endphp

            <x-form.input :floating_group="true" :name="$inputName" :placeholder="$inputLabel" :label="$inputLabel" :value="$interestName" />
        </div>
    @endforeach

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$interest->description" cols="30" rows="4" />
    </div>
</div>

@if ($interest->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
