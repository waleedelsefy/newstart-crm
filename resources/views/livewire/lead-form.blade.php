@push('styles')
@endpush

<div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-lg-12">
                <x-form.input wire:model="name" :floating_group="true" name="" :placeholder="__('Name')" :label="__('Name')" />
            </div>

            <div class="col-lg-12" wire:ignore>

                {{-- <div id="editor">{!! $notes !!}</div> --}}
                <x-form.textarea :floating_group="true" wire:model="notes" name="notes" label="{{ __('Notes') }}" />
            </div>

            <div class="col-lg-6 mt-5">
                <x-form.select wire:model="interestsIds" :select2="true" id="interests_ids" name="interests_ids[]"
                    label="{{ __('Interests') }}" multiple="multiple">
                    @foreach ($interests as $interest)
                        <option value="{{ $interest->id }}">{{ $interest->name }}</option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="col-lg-6 mt-5">
                <x-form.select wire:model="sourcesIds" :select2="true" id="sources_ids" name="sources_ids[]"
                    label="{{ __('Sources') }}" multiple="multiple">
                    @foreach ($sources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <x-form.select wire:model="developer_id" wire:change="changeProjectsPerDeveloper"
                            :select2="true" id="developer_id" name="developer_id" label="{{ __('Developer') }}">
                            <option value="" selected>
                                {{ __('All') }}
                            </option>

                            @foreach ($developersOptions as $developer)
                                <option value="{{ $developer->id }}">
                                    {{ $developer->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-lg-6" id="projects-select-container">
                        <x-form.select wire:model="projects_ids" id="projects_ids" name="projects_ids[]"
                            :select2="true" label="{{ __('Projects') }}" multiple="multiple">
                            @foreach ($projectsOptions ?? [] as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
            </div>

            {{-- @if (count($projects_ids))
                <div class="col-12 mb-1">
                    <x-buttons.primary wire:click="addProjects" text="{{ __('Add Projects') }}" icon="fa fa-plus"
                        class="btn-sm" type="button" />
                </div>
            @endif --}}

            @if (count($projects))
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Developer') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>
                                                {{ $project->name }}
                                            </td>
                                            <td>
                                                {{ $project->developer->name }}
                                            </td>

                                            <td>

                                                <x-buttons.danger text="{{ __('Delete') }}"
                                                    wire:click="removeProject({{ $project->id }},{{ $project->developer->id }})"
                                                    icon="fa fa-trash" class="btn-sm" type="button" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif



            <div class="col-lg-6">
                <div class="phones-fields" style="direction: ltr">

                    @for ($i = 0; $i < $phonesCount; $i++)
                        <div class="phones-container w-100 mb-1">
                            <div class="phone-field d-flex" style="gap: 5px">
                                <div style="width: 20%">
                                    <select wire:model="phones.{{ $i }}.code" id=""
                                        class="form-control">
                                        <option value="">{{ __('Code') }}</option>

                                        @foreach ($countriesOptions as $country)
                                            <option value="{{ $country->phone_code }}">
                                                +{{ $country->phone_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="width:80%">
                                    <input wire:model="phones.{{ $i }}.number"
                                        wire:blur='identifyPhoneCode("{{ $i }}")' type="number"
                                        class="form-control" placeholder="{{ __('Phone Number') }}">
                                </div>
                            </div>
                        </div>
                    @endfor


                    @if ($phonesCount < $phonesLimit)
                        <span wire:click="addNewPhoneField" class="add-phone-field btn btn-sm btn-success mb-2">
                            <i class="feather icon-plus"></i>
                        </span>
                    @endif

                    @if ($phonesCount > 1)
                        <span wire:click="removePhoneField" class="add-phone-field btn btn-sm btn-danger mb-2">
                            <i class="feather icon-minus"></i>
                        </span>
                    @endif
                </div>
            </div>


            <div class="col-lg-12">
                @if ($lead)
                    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
                @else
                    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
                @endif
            </div>

        </div>
    </form>
</div>

@push('scripts')
    <script>
        window.loadSelect2 = () => {
            $('#interests_ids').select2().on('change', function() {
                var data = $(this).val();
                @this.set('interestsIds', data);
            });

            $('#sources_ids').select2().on('change', function() {
                var data = $(this).val();
                @this.set('sourcesIds', data);
            });

            $('#developer_id').select2().on('change', function() {
                var data = $(this).val();
                @this.set('developer_id', data);
                livewire.emit('changeProjectsPerDeveloper');
            });

            $('#projects_ids').select2().on('change', function() {
                var data = $(this).val();
                @this.set('projects_ids', data);
                @this.emit('projectsUpdated')
            });
        }

        // var quill;


        window.addEventListener('render-select2', event => {
            $(".select2").select2();
        })

        // window.addEventListener('render-quill', event => {
        //     if (quill)
        //         quill.destroy()

        //     quill = new Quill('#editor', {
        //         theme: 'snow'
        //     });

        //     quill.on('text-change', () => {
        //         @this.set('notes', quill.root.innerHTML)
        //     });
        // })

        document.addEventListener("livewire:load", () => {
            loadSelect2();

            // var quill = new Quill('#editor', {
            //     theme: 'snow'
            // });


            // quill.on('text-change', () => {
            //     @this.set('notes', quill.root.innerHTML)
            // });

            window.livewire.on('select2Hydrate', () => {
                loadSelect2();
            });
        });
    </script>
@endpush
