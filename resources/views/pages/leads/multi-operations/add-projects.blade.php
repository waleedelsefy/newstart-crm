@extends('layouts.app')

@section('title', __('Add projects to leads'))

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
            <form action="{{ route('leads.multi-operations.add-interests') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <x-form.select :select2="true" id="developer_id" name="developer_id" label="{{ __('Developer') }}">
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->id }}" @selected(old('developer_id', $project->developer->id ?? '') == $developer->id)>
                                    {{ $developer->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-lg-6" id="projects-select-container">
                        <x-form.select :select2="true" id="projects_ids" name="projects_ids[]"
                            label="{{ __('Projects') }}" multiple="multiple">

                        </x-form.select>
                    </div>
                </div>

                <input type="text" name="leads_ids" value="{{ request()->get('leads_ids') }}" class="d-none">

                <x-buttons.primary text="{{ __('Add') }}" icon="fa fa-plus" />
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        (function() {
            ajaxProjectsByDeveloper($("#developer_id").val())
            $('#developer_id').on('select2:select', function(e) {
                ajaxProjectsByDeveloper(e.params.data.id)
            });
        })()

        function ajaxProjectsByDeveloper(developer_id) {
            $.ajax({
                url: "{{ route('ajaxProjectsByDeveloper') }}",
                method: "POST",
                data: {
                    developer_id,
                    lead_id: "{{ $lead->id }}",
                    _token: "{{ csrf_token() }}",
                },
                success: (response) => {
                    const projectsSelectSontainer = document.getElementById(
                        'projects-select-container');
                    projectsSelectSontainer.innerHTML = response;

                    $('#projects_ids').select2()
                },
                error: (e) => console.log(e)
            })
        }
    </script>
@endpush
