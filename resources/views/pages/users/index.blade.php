@extends('layouts.app')

@section('title', __('Users List'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection

@push('styles')
    <style>
        table td img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
@endpush


@section('content')
    <div class="card">
        <div class="card-body">

            <div class="top-actions mb-2 d-flex align-items-center justify-content-between flex-wrap" style="gap: 5px">
                <form action="{{ route('users.index') }}" method="GET" class="d-flex align-items-center flex-wrap"
                    style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" />

                    <x-form.select :select2="true" name="gender" label="{{ __('Gender') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        <option value="male" @selected(request()->get('gender') == 'male')>
                            {{ __('Male') }}
                        </option>
                        <option value="female" @selected(request()->get('gender') == 'female')>
                            {{ __('Female') }}
                        </option>
                    </x-form.select>

                    <x-form.select :select2="true" name="branch_id" label="{{ __('Branch') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request()->get('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </x-form.select>

                    <x-form.select :select2="true" name="role_id" label="{{ __('Role') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(request()->get('role_id') == $role->id)>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </x-form.select>

                    <x-form.select :select2="true" name="permission_id" label="{{ __('Permission') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" @selected(request()->get('permission_id') == $permission->id)>
                                {{ $permission->display_name }}
                            </option>
                        @endforeach
                    </x-form.select>
                </form>

                @can('create', \App\Models\User::class)
                    <x-buttons.primary href="{{ route('users.create') }}" text="{{ __('Add New User') }}" icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                            <th scope="col">{{ __('Branch') }}</th>
                            <th scope="col">{{ __('Job Title') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <img src="{{ $user->getPhoto() }}" alt="{{ $user->name }}">
                                </td>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{ $user->branch->name }}
                                </td>
                                <td>
                                    <x-badges.primary text="{{ $user->jobTitle() }}" />
                                </td>
                                <td>
                                    @can('update', $user)
                                        <x-buttons.success href="{{ route('users.edit', $user) }}" text="{{ __('Edit') }}"
                                            icon="fa fa-edit" class="btn-sm" />
                                    @endcan

                                    @can('delete', $user)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
