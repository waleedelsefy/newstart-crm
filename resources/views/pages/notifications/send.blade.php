@extends('layouts.app')

@section('title', __('Send Notifications'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        {{ __('Notifications') }}
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('notifications.store') }}" method="POST">

                @csrf

                <div class="row">
                    <div class="col-12">
                        <x-form.textarea :floating_group="true" name="message" placeholder="{{ __('Message') }}"
                            label="{{ __('Message') }}" value="{{ old('message') }}" cols="30" rows="4" />
                    </div>

                    <div class="col-12">
                        <x-form.input :floating_group="true" name="url" placeholder="{{ __('Url') }}"
                            label="{{ __('Url') }}" />
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                        <x-form.switch name="send_to_all" id="send-to-all" label="{{ __('Send to all') }}"
                            checked="{{ old('send-to-all') ?? null }}" />
                    </div>

                    <div class="col-12" id="choose-users">
                        <x-form.select :select2="true" id="users" name="users_ids[]" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }} [ {{ $user->jobTitle() }} ]
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>

                <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
            </form>
        </div>
    </div>


@endsection


@push('scripts')
    <script>
        $("#send-to-all").on('change', function() {
            if (this.checked) {
                $("#choose-users").hide();
            } else {
                $("#choose-users").show();
            }
        })
    </script>
@endpush
