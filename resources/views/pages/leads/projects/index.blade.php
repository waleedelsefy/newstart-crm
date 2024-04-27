@extends('layouts.app')

@section('title', __('Projects List'))

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

            <div class="top-actions mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 5px">
                <form action="{{ route('leads.projects.index', $lead) }}" method="GET"
                    class="d-flex align-items-center flex-wrap" style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" class="mb-0" />

                </form>

                @can('create-lead-projects')
                    <x-buttons.primary href="{{ route('leads.projects.create', $lead) }}" text="{{ __('Add New Project') }}"
                        icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Developer') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>
                                    {{ $project->name }}
                                </td>
                                <td>
                                    {{ $project->developer->name }}
                                </td>

                                <td>
                                    @can('delete-lead-projects')
                                        <form action="{{ route('leads.projects.destroy', [$lead, $project]) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')

                                            <x-buttons.danger text="{{ __('Delete') }}"
                                                onclick="return confirm('{{ __('messages.confirm-delete') }}')"
                                                icon="fa fa-trash" class="btn-sm" />
                                        </form>
                                    @endcan
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
            {{ $projects->links() }}
        </div>
    </div>
@endsection
