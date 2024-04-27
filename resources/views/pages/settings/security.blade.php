@extends('layouts.app')

@section('title', __('Security'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        {{ __('Settings') }}
    </li>

    <li class="breadcrumb-item active">
        @yield('title')
    </li>
@endsection

@push('styles')
    <style>
        .recovery-codes-title {
            font-weight: bold;
        }

        .recovery-codes-item {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.8
        }
    </style>
@endpush


@section('content')
    <div class="card">

        <div class="card-body">
            <x-headings.h3 class="mb-2">{{ __('Two Factor Authentication') }}</x-headings.h3>

            @if (!Auth::user()->two_factor_secret)
                <form action="{{ route('two-factor.enable') }}" method="POST">
                    @csrf

                    <x-buttons.success text="{{ __('Enable') }}" class="mb-1" />
                </form>
            @else
                <form action="{{ route('two-factor.disable') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <x-buttons.danger text="{{ __('Disable') }}" class="mb-1" />
                </form>

                <x-alerts.success if="{{ session()->get('status') == 'two-factor-authentication-enabled' }}"
                    message="{{ __('Please finish configuring the two-factor authentication below.') }}" />


                @if (!request()->user()->two_factor_confirmed_at)
                    <div class="p-2">
                        {!! request()->user()->twoFactorQrCodeSvg() !!}
                    </div>

                    <form action="{{ route('two-factor.confirm') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">

                                <x-form.input :floating_group="true" icon="feather icon-lock" name="code"
                                    placeholder="{{ __('Code') }}" label="{{ __('Code') }}"
                                    error_bag="confirmTwoFactorAuthentication" />
                            </div>
                        </div>

                        <x-buttons.success text="{{ __('Confirm') }}" />
                    </form>
                @endif

                @if (session('status') == 'two-factor-authentication-confirmed')
                    <x-alerts.success
                        message="{{ __('Two-factor authentication was confirmed and enabled successfully.') }}" />

                    <div class="recovery-codes-list">
                        <h5 class="recovery-codes-title">{{ __('Recovery Codes') }}</h5>

                        <ul>
                            @foreach (request()->user()->recoveryCodes() as $recoveryCode)
                                <li class="recovery-codes-item">{{ $recoveryCode }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <x-alerts.success if="{{ session()->get('status') == 'two-factor-authentication-disabled' }}"
                message="{{ __('Two-factor authentication has been disabled.') }}" />

        </div>
    </div>

    <div class="card">

        <div class="card-body">

            <x-alerts.success if="{{ session()->get('status') == 'password-updated' }}"
                message="{{ __('Your password has been updated.') }}" />

            <x-headings.h3 class="mb-2">{{ __('Change password') }}</x-headings.h3>

            <form action="{{ route('user-password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xl-5 col-lg-6">
                        <x-form.input type="password" :floating_group="true" icon="feather icon-lock" name="current_password"
                            label="{{ __('Current Password') }}" placeholder="{{ __('Current Password') }}"
                            error_bag="updatePassword" />

                        <x-form.input type="password" :floating_group="true" icon="feather icon-lock" name="password"
                            label="{{ __('Password') }}" placeholder="{{ __('Password') }}" error_bag="updatePassword" />

                        <x-form.input type="password" :floating_group="true" icon="feather icon-lock"
                            name="password_confirmation" label="{{ __('Password Confirmation') }}"
                            placeholder="{{ __('Password Confirmation') }}" error_bag="updatePassword" />
                    </div>
                </div>

                <x-buttons.success text="{{ __('Update') }}" />
            </form>
        </div>

    </div>
@endsection
