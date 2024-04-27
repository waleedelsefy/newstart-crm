@extends('layouts.app')

@section('title', __('Edit User'))

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
            <form action="{{ route('users.update-photo', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('pages.users._form-photo')
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update-password', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @include('pages.users._form-password')
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <x-headings.h3 class="mb-2">{{ __('Update Profile Information') }}</x-headings.h3>

            <form action="{{ route('users.update', $user) }}" method="POST">
                @include('pages.users._form')
            </form>
        </div>
    </div>


@endsection
