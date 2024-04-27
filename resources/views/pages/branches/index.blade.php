@extends('layouts.app')

@section('title', __('Branches List'))

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
                <form action="{{ route('branches.index') }}" method="GET" class="d-flex align-items-center flex-wrap"
                    style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" />

                    <x-form.select :select2="true" name="status" label="{{ __('Status') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($availableStatus as $key => $val)
                            <option value="{{ $key }}" @selected(request()->get('status') == $key)>{{ __($val) }}
                            </option>
                        @endforeach
                    </x-form.select>

                </form>

                @can('create', \App\Models\Branch::class)
                    <x-buttons.primary href="{{ route('branches.create') }}" text="{{ __('Add New Branch') }}"
                        icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $branch->id }}</td>
                                <td>
                                    <a href="{{ route('users.index', ['branch_id' => $branch->id]) }}">{{ $branch->name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($branch->status == 'Open')
                                        <x-badges.primary :text="$branch->status" icon="feather icon-check-circle" />
                                    @elseif ($branch->status == 'Temporarily Closed')
                                        <x-badges.warning :text="$branch->status" icon="feather icon-alert-circle" />
                                    @elseif ($branch->status == 'Closed')
                                        <x-badges.danger :text="$branch->status" icon="feather icon-x-circle" />
                                    @endif
                                </td>
                                <td>
                                    @can('update', $branch)
                                        <x-buttons.success href="{{ route('branches.edit', $branch) }}"
                                            text="{{ __('Edit') }}" icon="fa fa-edit" class="btn-sm" />
                                    @endcan

                                    @can('delete', $branch)
                                        <form action="{{ route('branches.destroy', $branch) }}" method="POST"
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
            {{ $branches->links() }}
        </div>
    </div>
@endsection
