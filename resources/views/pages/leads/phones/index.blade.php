@extends('layouts.app')

@section('title', __('Phones List'))

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
                <form action="{{ route('leads.phones.index', $lead) }}" method="GET"
                    class="d-flex align-items-center flex-wrap" style="gap: 5px">

                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        :value="request()->get('search')" class="mb-0" />

                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Phone Number') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($phones as $phone)
                            <tr>
                                <td>{{ $phone->id }}</td>
                                <td style="direction: ltr">
                                    {{ $phone->number }}
                                </td>

                                <td>
                                    <x-buttons.success
                                        href="https://api.whatsapp.com/send?phone={{ $phone->phoneWithoutPlus() }}"
                                        text="" icon="fa fa-whatsapp" class="btn-sm" target="blank" />

                                    <x-buttons.primary href="tel:{{ $phone->number }}" text="" icon="fa fa-phone"
                                        class="btn-sm" />


                                    @can('delete-lead-phones')
                                        <form action="{{ route('leads.phones.destroy', [$lead, $phone]) }}" method="POST"
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
            {{ $phones->links() }}
        </div>
    </div>
@endsection
