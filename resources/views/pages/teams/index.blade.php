@extends('layouts.app')

@section('title', __('Teams List'))

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
                <form action="{{ route('teams.index') }}" method="GET" class="d-flex align-items-center flex-wrap"
                    style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" class="mb-0" />

                    <x-form.select :select2="true" name="team_role" label="{{ __('Team Role') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        <option value="leader" @selected(request()->get('team_role') == 'leader')>{{ __('I am the Leader') }}</option>
                        <option value="member" @selected(request()->get('team_role') == 'member')>{{ __('I am the Member') }}</option>
                    </x-form.select>
                </form>



                @can('create', \App\Models\Team::class)
                    <x-buttons.primary href="{{ route('teams.create') }}" text="{{ __('Add New Team') }}" icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Team Type') }}</th>
                            <th scope="col">{{ __('Leader') }}</th>
                            <th scope="col">{{ __('Members') }}</th>
                            <th scope="col">{{ __('Created By') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td>
                                    <a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a>
                                </td>
                                <td>
                                    {{ $team->type() }}
                                </td>
                                <td>
                                    <a
                                        href="{{ $team->leader ? route('users.edit', $team->leader) : '#' }}">{{ $team->leader->name ?? __('Unknown') }}</a>
                                </td>

                                <td>
                                    <x-badges.primary text="{{ $team->members_count }}" icon="feather icon-users" />
                                </td>

                                <td>
                                    {{ $team->createdBy->name ?? __('Unknown') }}
                                </td>


                                <td>
                                    @can('update', $team)
                                        <x-buttons.info href="{{ route('teams.members', $team) }}" text="{{ __('Members') }}"
                                            icon="fa fa-plus" class="btn-sm" />
                                    @endcan

                                    @can('update', $team)
                                        <x-buttons.success href="{{ route('teams.edit', $team) }}" text="{{ __('Edit') }}"
                                            icon="fa fa-edit" class="btn-sm" />
                                    @endcan

                                    @can('delete', $team)
                                        <form action="{{ route('teams.destroy', $team) }}" method="POST"
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
            {{ $teams->links() }}
        </div>
    </div>
@endsection
