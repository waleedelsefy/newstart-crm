@extends('layouts.app')

@section('title', __('Assign leads to a user'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('leads.index') }}">{{ __('Leads List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.multi-operations.assign-to') }}" method="POST">
                @csrf

                <div class="row mb-1">
                    <div class="col-lg-6">
                        <x-form.select :select2="true" name="assignable_id" label="{{ __('Users') }}">
                            <option value="">{{ __('Not Assigned') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('assignable_id') == $user->id)>{{ $user->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-12">
                        <x-form.switch name="show_old_hisory" label="{{ __('Show the old history?') }}" value="1" />
                    </div>

                    @if (auth()->user()->hasPermissions(['change-lead-event']))
                        <div class="col-12">
                            <x-form.switch name="add_event" label="{{ __('Add event') }}" value="1" />
                        </div>
                    @endif
                </div>

                <input type="text" name="leads_ids" value="{{ request()->get('leads_ids') }}" class="d-none">

                <x-buttons.primary text="{{ __('Add') }}" icon="fa fa-plus" />
            </form>
        </div>
    </div>


@endsection
