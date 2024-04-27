@extends('layouts.guest')


@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        <img src="{{ asset('images/pages/login.png') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">{{ __('Login') }}</h4>
                                </div>
                            </div>
                            <p class="px-2">{{ __('Welcome back, please log in to your account.') }}</p>
                            <div class="card-content">
                                <div class="card-body pt-1">
                                    <form action="{{ route('login') }}" method="POST">

                                        @csrf

                                        <x-form.input :floating_group="true" icon="feather icon-user" :name="config('fortify.username')"
                                            placeholder="{{ __('Username') }} / {{ __('Email') }} / {{ __('Phone Number') }}"
                                            label="Name" :value="old(config('fortify.username'))" />


                                        <x-form.input :floating_group="true" icon="feather icon-lock" type="password"
                                            name="password" placeholder="{{ __('Password') }}"
                                            label="{{ __('Password') }}" />

                                        <div class=" d-flex justify-content-between align-items-center">
                                            <div class="text-left">
                                                <x-form.checkbox name="remember" label="{{ __('Remember me') }}"
                                                    icon="feather icon-check" />
                                            </div>

                                            @if (Route::has('password.request'))
                                                <div class="text-right mb-2">
                                                    <a href="{{ route('password.request') }}" class="card-link">
                                                        {{ __('Forgot Password?') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <x-buttons.primary text="{{ __('Login') }}" class="w-100 mb-2" />

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
