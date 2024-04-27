@extends('layouts.app')

@section('title', __('Interests List'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')
    <div class="card">
        <div class="card-body">

            <div class="top-actions mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 5px">
                <form action="{{ route('interests.index') }}" method="GET" class="d-flex align-items-center flex-wrap"
                    style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" class="mb-0" />

                </form>

                @can('create', \App\Models\Interest::class)
                    <x-buttons.primary href="{{ route('interests.create') }}" text="{{ __('Add New Interest') }}"
                        icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($interests as $interest)
                            <tr>
                                <td>{{ $interest->id }}</td>
                                <td>
                                    {{ $interest->name }}
                                </td>

                                <td>
                                    @can('update', $interest)
                                        <x-buttons.success href="{{ route('interests.edit', $interest) }}"
                                            text="{{ __('Edit') }}" icon="fa fa-edit" class="btn-sm" />
                                    @endcan

                                    @can('delete', $interest)
                                        <form action="{{ route('interests.destroy', $interest) }}" method="POST"
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
            {{ $interests->links() }}
        </div>
    </div>
@endsection
