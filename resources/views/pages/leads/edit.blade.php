@extends('layouts.app')

@section('title', __('Edit Lead'))

@section('styles')
    @livewireStyles

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />

@endsection

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

            <livewire:lead-form :lead="$lead ?? null" />

            {{-- <form action="{{ route('leads.update', $lead) }}" method="POST">
                @include('pages.leads._form')
            </form> --}}
        </div>
    </div>


@endsection


@section('scripts')
    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>
@endsection
