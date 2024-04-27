@extends('layouts.guest')


@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">

                    <div class="col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">{{ __('Two Factor Authentication') }}</h4>
                                </div>
                            </div>
                            <p class="px-2">{{ __('You should confirm by typing your 2FA Code.') }}</p>
                            <div class="card-content">



                                <div class="card-body pt-1">
                                    <form action="{{ route('two-factor.login') }}" method="POST">

                                        @csrf

                                        <x-form.input :floating_group="true" icon="feather icon-lock" name="code"
                                            placeholder="{{ __('Code') }}" label="{{ __('Code') }}" />


                                        <div class="divider">
                                            <div class="divider-text">{{ __('OR') }}</div>
                                        </div>

                                        <x-form.input :floating_group="true" icon="feather icon-lock" name="recovery_code"
                                            placeholder="{{ __('Recovery code') }}" label="{{ __('Recovery code') }}" />

                                        <x-buttons.primary text="{{ __('Confirm') }}" class="w-100 mb-2" />

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
