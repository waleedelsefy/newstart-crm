@extends('layouts.app')

@section('title', __('Before Deleting'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">
        <a href="{{ route('users.index') }}">{{ __('Users List') }}</a>
    </li>

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection


@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('users.before-deleting', $user) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="row">
                    @if ($user->leadsAssignedToYou->count() > 0)
                        <div class="col-lg-6">
                            <x-form.select :select2="true" name="assign_to" label="{{ __('Assign his leads to?') }}">
                                @foreach ($assignToUsers as $assignToUser)
                                    <option value="{{ $assignToUser->id }}" @selected(old('assign_to', $assignToUser->id) == $user->id)>
                                        {{ $assignToUser->username }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    @endif

                    @if (count($leaders))
                        <div class="col-lg-6">
                            <x-form.select :select2="true" name="leader_id"
                                label="{{ __('Change team leader of his teams') }}">
                                @foreach ($leaders as $leader)
                                    <option value="{{ $leader->id }}" @selected(old('leader_id', $leader->id) == $user->id)>
                                        {{ $leader->username }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    @endif
                </div>

                <x-buttons.danger text="{{ __('Delete') }}"
                    onclick="return confirm('{{ __('messages.confirm-delete') }}')" icon="fa fa-trash" />
            </form>
        </div>
    </div>


@endsection
