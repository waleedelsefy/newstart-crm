@extends('layouts.app')

@section('title', __('Projects Reports'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        <a href="{{ route('reports.index') }}">{{ __('Reports') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="row">

        <div class="col-12 mb-2">
            @include('pages.reports.partials._form-filter')
        </div>

        @foreach ($projects as $project)
            <div class="col-xl-4 col-lg-6">
                <div class="card mb-1">
                    <div class="card-body text-center py-1">

                        <div class="d-flex align-items-center justify-content-between">

                            <x-headings.h3 class="card-title m-0">
                                <a
                                    href="{{ route('leads.index', [
                                        'projects_ids[0]' => $project->id,
                                        'from_date' => request()->get('from_date'),
                                        'to_date' => request()->get('to_date'),
                                    ]) }}">{{ $project->name }}</a>
                            </x-headings.h3>

                            <x-headings.h5 class="card-title m-0">{{ $project->leads_count }}</x-headings.h5>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bottom-actions mt-2">
        <div class="app-pagination">
            {{ $projects->links() }}
        </div>
    </div>
@endsection
