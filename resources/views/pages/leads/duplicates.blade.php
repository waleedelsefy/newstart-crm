@extends('layouts.app')

@section('title', __('Duplicates'))

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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Lead') }}</th>
                            <th scope="col">{{ __('Assigned To') }}</th>
                            <th scope="col">{{ __('Date') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>
                                    <a href="{{ route('leads.show', $lead) }}">
                                        <div class="avatar avatar-xl">
                                            <img src="{{ Avatar::create($lead->name)->toBase64() }}"
                                                alt="{{ $lead->name }}">
                                        </div>

                                        <x-headings.h5>
                                            {{ $lead->name }}
                                        </x-headings.h5>
                                    </a>
                                </td>
                                <td>
                                    <a
                                        href="{{ $lead->assignedTo ? route('users.show', $lead->assignedTo) : 'javascript:void()' }}">
                                        <div class="avatar avatar-xl">
                                            <img src="{{ $lead->assignedTo?->getPhoto() ?? Avatar::create('Unknown')->toBase64() }}"
                                                alt="{{ $lead->name }}">
                                        </div>

                                        <h5>{{ $lead->assignedTo->username ?? __('Unknown') }}</h5>
                                    </a>
                                </td>

                                <td>
                                    {{ $lead->createdAt() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    <div class="bottom-actions mt-2">
        <div class="app-pagination">
            {{ $leads->links() }}
        </div>
    </div>

@endsection
