@extends('layouts.app')

@section('title', __('Events List'))

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
                <form action="{{ route('events.index') }}" method="GET" class="d-flex align-items-center flex-wrap"
                    style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" class="mb-0" />

                    <x-form.select :select2="true" name="with_date" label="{{ __('With Date') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        <option value="yes" @selected(request()->get('with_date') == 'yes')>
                            {{ __('Yes') }}
                        </option>
                        <option value="no" @selected(request()->get('with_date') == 'no')>
                            {{ __('No') }}
                        </option>
                    </x-form.select>

                    <x-form.select :select2="true" name="with_notes" label="{{ __('With Notes') }}"
                        onchange="this.form.submit()">
                        <option value="">{{ __('All') }}</option>
                        <option value="yes" @selected(request()->get('with_notes') == 'yes')>
                            {{ __('Yes') }}
                        </option>
                        <option value="no" @selected(request()->get('with_notes') == 'no')>
                            {{ __('No') }}
                        </option>
                    </x-form.select>

                </form>

                @can('create', \App\Models\Event::class)
                    <x-buttons.primary href="{{ route('events.create') }}" text="{{ __('Add New Event') }}"
                        icon="fa fa-plus" />
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('With Date') }}</th>
                            <th scope="col">{{ __('With Notes') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>
                                    {{ $event->name }}
                                </td>
                                <td>
                                    @if ($event->with_date == 'yes')
                                        <x-badges.primary text="{{ __('Yes') }}" icon="feather icon-check-circle" />
                                    @else
                                        <x-badges.light text="{{ __('No') }}" icon="feather icon-x-circle" />
                                    @endif
                                </td>
                                <td>
                                    @if ($event->with_notes == 'yes')
                                        <x-badges.primary text="{{ __('Yes') }}" icon="feather icon-check-circle" />
                                    @else
                                        <x-badges.light text="{{ __('No') }}" icon="feather icon-x-circle" />
                                    @endif
                                </td>

                                <td>
                                    @can('update', $event)
                                        <x-buttons.success href="{{ route('events.edit', $event) }}"
                                            text="{{ __('Edit') }}" icon="fa fa-edit" class="btn-sm" />
                                    @endcan

                                    @can('delete', $event)
                                        <form action="{{ route('events.destroy', $event) }}" method="POST"
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
            {{ $events->links() }}
        </div>
    </div>
@endsection
