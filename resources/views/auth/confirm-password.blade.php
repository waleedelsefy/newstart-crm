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
                                    <h4 class="mb-0">{{ __('Confirm Action') }}</h4>
                                </div>
                            </div>
                            <p class="px-2">{{ __('You must confirm your identity by typing in the password') }}</p>
                            <div class="card-content">
                                <div class="card-body pt-1">
                                    <form action="{{ route('password.confirm') }}" method="POST">

                                        @csrf

                                        <x-form.input :floating_group="true" icon="feather icon-lock" name="password"
                                            placeholder="{{ __('Password') }}" label="{{ __('Password') }}"
                                            type="password" />


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
