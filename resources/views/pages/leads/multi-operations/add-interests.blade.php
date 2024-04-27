@extends('layouts.app')

@section('title', __('Add interests to leads'))

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
            <form action="{{ route('leads.multi-operations.add-interests') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <x-form.select :select2="true" name="interests_ids[]" label="{{ __('Interests') }}"
                            multiple="multiple">
                            @foreach ($interests as $interest)
                                <option value="{{ $interest->id }}" @selected(in_array($interest->id, old('interests_ids', [])))>{{ $interest->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>

                <input type="text" name="leads_ids" value="{{ request()->get('leads_ids') }}" class="d-none">

                <x-buttons.primary text="{{ __('Add') }}" icon="fa fa-plus" />
            </form>
        </div>
    </div>


@endsection
