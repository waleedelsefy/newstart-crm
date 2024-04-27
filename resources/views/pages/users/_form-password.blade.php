<x-headings.h3 class="mb-2">{{ __('Update Profile Information') }}</x-headings.h3>

<div class="row">
    <div class="col-xl-5 col-lg-6">
        <x-form.input type="password" :floating_group="true" icon="feather icon-lock" name="password"
            label="{{ __('Password') }}" placeholder="{{ __('Password') }}" />

        <x-form.input type="password" :floating_group="true" icon="feather icon-lock" name="password_confirmation"
            label="{{ __('Password Confirmation') }}" placeholder="{{ __('Password Confirmation') }}" />
    </div>
</div>

<x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
