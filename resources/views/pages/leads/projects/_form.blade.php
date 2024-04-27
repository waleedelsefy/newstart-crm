@csrf

@if ($project->name)
    @method('PUT')
@endif


@if (count($errors) > 0)
    <div class="p-1">
        @foreach ($errors->all() as $error)
            <x-alerts.danger :message="$error" />
        @endforeach
    </div>
@endif

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
        <x-form.select :select2="true" id="projects_ids" name="projects_ids[]" label="{{ __('Projects') }}"
            multiple="multiple">

        </x-form.select>
    </div>
</div>

@if ($project->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif


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
