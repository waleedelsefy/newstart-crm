@extends('layouts.app')

@section('title', __('Edit Event'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('leads.index') }}">{{ __('Leads List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/pickers/pickadate/pickadate.css') }}">
@endpush

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.event', $lead) }}" method="POST">
                @csrf

                <div class="col-xl-6 col-lg-8 p-0">
                    <div class="row mb-2">
                        <div class="col-12">
                            <x-form.select :select2="true" name="event_id" id="event_id" label="{{ __('Events') }}">
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}" @selected($event->id == old('event_id', $lead->lastEvent()?->event_id))>{{ $event->name }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>

                        <div class="col-12">
                            <x-form.textarea :floating_group="true" name="notes" placeholder="{{ __('Notes') }}"
                                label="{{ __('Notes') }}" :value="old('notes')" cols="30" rows="4" />
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date">{{ __('Date') }}</label>
                                <input type="date" name="date" id="date" class="form-control">
                                @error('date')
                                    <small class="d-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="time">{{ __('Time') }}</label>
                                <input type="time" name="time" id="time" class="form-control">
                                @error('time')
                                    <small class="d-block text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
                </div>
            </form>
        </div>
    </div>


@endsection


@push('scripts')
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>

    <script src="{{ asset('js/scripts/pickers/dateTime/pick-a-datetime.js') }}"></script>
@endpush
