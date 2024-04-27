@csrf

@if ($project->name)
    @method('PUT')
@endif



<div class="row">
    @foreach (config('laravellocalization.supportedLocales') as $locale => $options)
        <div class="col-lg-6">
            @php
                $projectName = $project->name ? $project->getTranslations('name')[$locale] : '';
                $inputLabel = __('Name In ' . $options['name']);
                $inputName = "name[$locale]";
            @endphp

            <x-form.input :floating_group="true" :name="$inputName" :placeholder="$inputLabel" :label="$inputLabel" :value="$projectName" />
        </div>
    @endforeach

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$project->description" cols="30" rows="4" />
    </div>

    <div class="col-lg-12">
        <x-form.select :select2="true" name="developer_id" label="{{ __('Developer') }}">
            @foreach ($developers as $developer)
                <option value="{{ $developer->id }}" @selected(old('developer_id', $project->developer->id ?? '') == $developer->id)>{{ $developer->name }}
                </option>
            @endforeach
        </x-form.select>
    </div>
</div>

@if ($project->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
