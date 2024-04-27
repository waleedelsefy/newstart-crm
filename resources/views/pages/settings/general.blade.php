@extends('layouts.app')

@section('title', __('General'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        {{ __('Settings') }}
    </li>

    <li class="breadcrumb-item active">
        @yield('title')
    </li>
@endsection


@section('content')
    <div class="card">

        <div class="card-body">
            <x-headings.h3 class="mb-2">{{ __('Update Profile Photo') }}</x-headings.h3>

            <form action="{{ route('settings.user-profile-photo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-form.change-photo name="photo" src="{{ $user->getPhoto() }}" alt="{{ $user->username }}" />
            </form>
        </div>

    </div>

    <div class="card">

        <div class="card-body">
            <x-headings.h3 class="mb-2">{{ __('Update Profile Information') }}</x-headings.h3>

            <form action="{{ route('user-profile-information.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xl-5 col-lg-6">

                        <x-form.input :floating_group="true" icon="feather icon-user" name="name"
                            placeholder="{{ __('Name') }}" label="{{ __('Name') }}" :value="$user->name"
                            error_bag="updateProfileInformation" />

                        <x-form.input :floating_group="true" icon="feather icon-user" name="username"
                            placeholder="{{ __('Username') }}" label="{{ __('Username') }}" :value="$user->username"
                            error_bag="updateProfileInformation" />

                        <x-form.input :floating_group="true" type="email" icon="feather icon-mail" name="email"
                            placeholder="{{ __('Email') }}" label="{{ __('Email') }}" :value="$user->email"
                            error_bag="updateProfileInformation" />


                        <div class="row">
                            <div class="col-3">
                                <x-form.select :select2="true" name="country_code" error_bag="updateProfileInformation">
                                    <option value="+20" @selected(old('country_code', $user->country_code) == '+20')>+20</option>
                                    <option value="+976" @selected(old('country_code', $user->country_code) == '+976')>+976</option>
                                </x-form.select>
                            </div>

                            <div class="col-9">
                                <x-form.input :floating_group="true" icon="feather icon-phone" name="phone_number"
                                    placeholder="{{ __('Phone Number') }}" label="{{ __('Phone Number') }}"
                                    :value="$user->phoneWithoutCode()" error_bag="updateProfileInformation" />
                            </div>
                        </div>

                        <x-form.select :select2="true" name="gender" label="{{ __('Gender') }}"
                            error_bag="updateProfileInformation">
                            <option value="male" @selected(old('gender', $user->gender) == 'male')>{{ __('Male') }}</option>
                            <option value="female" @selected(old('gender', $user->gender) == 'female')>{{ __('Female') }}</option>
                        </x-form.select>

                        <x-form.textarea :floating_group="true" name="bio" placeholder="{{ __('Bio') }}"
                            label="{{ __('Bio') }}" :value="$user->bio" error_bag="updateProfileInformation"
                            cols="30" rows="4" />

                    </div>
                </div>

                <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
            </form>
        </div>

    </div>
@endsection
