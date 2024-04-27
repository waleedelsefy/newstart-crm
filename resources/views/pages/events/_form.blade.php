@csrf

@if ($event->name)
    @method('PUT')
@endif



<div class="row">
    <div class="col-lg-12">
        <x-form.input :floating_group="true" name="name" placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
            :value="$event->name" />
    </div>

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$event->description" cols="30" rows="4" />
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
        <x-form.switch name="with_date" label="{{ __('With Date') }}" value="yes" :checked="old('with_date', $event->with_date) == 'yes'" />
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
        <x-form.switch name="with_notes" label="{{ __('With Notes') }}" value="yes" :checked="old('with_notes', $event->with_notes) == 'yes'" />
    </div>
</div>

@if ($event->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
