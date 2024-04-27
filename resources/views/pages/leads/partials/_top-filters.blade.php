<div class="top-filters">
    <form action="{{ route('leads.index') }}" method="GET">
        <div class="scrollable-leads-filter">
            <div class="scrollable-wrapper">

                @can('lead-search-filter')
                    <div class="scrollable-slide">
                        <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                            :value="request()->get('search')" class="mb-0" />
                    </div>
                @endcan

                @can('lead-branch-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="branches_ids[]" multiple label="{{ __('Branches') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @selected(in_array($branch->id, request()->get('branches_ids') ?? []))>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-event-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="events_ids[]" multiple label="{{ __('Events') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->name }}" @selected(in_array($event->name, request()->get('events_ids') ?? []))>
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-reminder-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="reminder" label="{{ __('Reminder') }}">
                            <option value="">{{ __('All') }}</option>

                            <option value="upcoming" @selected(request()->get('reminder') == 'upcoming')>
                                {{ __('Upcoming') }}
                            </option>

                            <option value="today" @selected(request()->get('reminder') == 'today')>
                                {{ __('Today') }}
                            </option>

                            <option value="delay" @selected(request()->get('reminder') == 'delay')>
                                {{ __('Delay') }}
                            </option>
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-assign-to-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="assigned_to" label="{{ __('Assign To') }}">
                            <option value="">{{ __('All') }}</option>

                            <option value="me" @selected(request()->get('assigned_to') == 'me')>
                                {{ __('Me') }}
                            </option>

                            <option value="my_team" @selected(request()->get('assigned_to') == 'my_team')>
                                {{ __('My Team') }}
                            </option>

                            <option value="me_my_team" @selected(request()->get('assigned_to') == 'me_my_team')>
                                {{ __('Me & My Team') }}
                            </option>
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-assign-to-user-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="assigned_to_users[]" multiple
                            label="{{ __('Assign To Users') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($usersAvailableToAssign as $user)
                                <option value="{{ $user->id }}" @selected(in_array($user->id, request()->get('assigned_to_users') ?? []))>
                                    {{ $user->username }} - [ {{ $user->jobTitle() }} ]
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-assign-to-team-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="assigned_to_team" label="{{ __('Assign To Team') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($usersSalesTeamLeaders as $user)
                                <option value="{{ $user->id }}" @selected(request()->get('assigned_to_team') == $user->id)>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-assign-by-user-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="assigned_by_users[]" multiple
                            label="{{ __('Assign By Users') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($usersCanAssignLeadsToEmployees as $user)
                                <option value="{{ $user->id }}" @selected(in_array($user->id, request()->get('assigned_by_users') ?? []))>
                                    {{ $user->username }} - [ {{ $user->jobTitle() }} ]
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-source-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="sources_ids[]" multiple label="{{ __('Sources') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}" @selected(in_array($source->id, request()->get('sources_ids') ?? []))>
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-interest-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="interests_ids[]" multiple label="{{ __('Interests') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($interests as $interest)
                                <option value="{{ $interest->id }}" @selected(in_array($interest->id, request()->get('interests_ids') ?? []))>
                                    {{ $interest->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-project-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="projects_ids[]" multiple label="{{ __('Projects') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @selected(in_array($project->id, request()->get('projects_ids') ?? []))>
                                    {{ $project->name }} - [ {{ $project->developer->name }} ]
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-created-by-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="creators_ids[]" multiple label="{{ __('Created By') }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($creators as $creator)
                                <option value="{{ $creator->id }}" @selected(in_array($creator->id, request()->get('creators_ids') ?? []))>
                                    {{ $creator->username }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-created-by-filter')
                    <div class="scrollable-slide">
                        <x-form.select :select2="true" name="created_by" label="{{ __('Created By') }}">
                            <option value="">{{ __('All') }}</option>

                            <option value="me" @selected(request()->get('created_by') == 'me')>
                                {{ __('Me') }}
                            </option>

                            <option value="my_team" @selected(request()->get('created_by') == 'my_team')>
                                {{ __('My Team') }}
                            </option>

                            <option value="me_my_team" @selected(request()->get('created_by') == 'me_my_team')>
                                {{ __('Me & My Team') }}
                            </option>
                        </x-form.select>
                    </div>
                @endcan

                @can('lead-created-at-filter')
                    <div class="scrollable-slide">
                        <div class="form-group">
                            <label for="from_date">{{ __('From Date') }}</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request()->get('from_date') }}">
                        </div>
                    </div>

                    <div class="scrollable-slide">
                        <div class="form-group">
                            <label for="to_date">{{ __('To Date') }}</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request()->get('to_date') }}">
                        </div>
                    </div>
                @endcan
            </div>

        </div>

        <div style="margin-top: 4px;gap:5px" class="d-flex align-items-center">
            <x-buttons.primary text="{{ __('Search') }}" icon="feather icon-search" />

            <x-buttons.light href="{{ route('leads.index') }}" text="{{ __('Reset') }}"
                icon="feather icon-loader" />


        </div>

        <div class="d-flex mt-1" style="gap: 5px">
            <div>{{ __('Leads') }}: {{ $leadsCount }}</div>

            @can('lead-not-assigned-filter')
                <x-form.switch name="not_assigned" label="{{ __('Not Assigned') }}" value="1" :checked="request()->get('not_assigned') == 1"
                    class="mx-1" />
            @endcan
        </div>
    </form>

    <div class="d-flex align-items-center justify-content-end">

        @can('view-lead-multi-options')
            <div class="dropdown">
                <div class="dropdown">
                    <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-settings"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">

                        @can('export-lead-excel')
                            <form action="{{ route('leads.export', request()->query()) }}" method="POST"
                                class="d-inline-block">
                                @csrf

                                <input type="text" name="leads_ids" class="leads_ids_hidden_inputs d-none">

                                <button class="dropdown-item">
                                    <i class="feather icon-download-cloud"></i>
                                    {{ __('Export leads to Excel sheet') }}
                                </button>


                            </form>
                        @endcan

                        @can('import-lead-excel')
                            <form action="{{ route('leads.import') }}" method="POST" class="d-inline-block"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="file" name="excel_file" id="excel_file" style="display: none"
                                    onchange="this.form.submit()">

                                <label for="excel_file" class="dropdown-item">
                                    <i class="feather icon-upload-cloud"></i>
                                    {{ __('Import leads from Excel sheet') }}
                                </label>
                            </form>
                        @endcan

                        @can('view-lead-select')
                            <div class="multi-operations d-none">
                                @can('assign-lead-to-employee')
                                    <a class="dropdown-item link-to-view" href="javascript:void(0)"
                                        data-route="{{ route('leads.multi-operations.assign-to') }}">

                                        <i class="feather icon-user"></i>
                                        {{ __('Assign To') }}
                                    </a>
                                @endcan

                                @can('change-lead-event')
                                    <a class="dropdown-item link-to-view" href="javascript:void(0)"
                                        data-route="{{ route('leads.multi-operations.add-event') }}">

                                        <i class="feather icon-activity"></i>
                                        {{ __('Add Event') }}
                                    </a>
                                @endcan

                                @can('update-lead-sources')
                                    <a class="dropdown-item link-to-view" href="javascript:void(0)"
                                        data-route="{{ route('leads.multi-operations.add-sources') }}">
                                        <i class="feather icon-search"></i>
                                        {{ __('Add Sources') }}
                                    </a>
                                @endcan

                                @can('update-lead-interests')
                                    <a class="dropdown-item link-to-view" href="javascript:void(0)"
                                        data-route="{{ route('leads.multi-operations.add-interests') }}">
                                        <i class="feather icon-heart"></i>
                                        {{ __('Add Interests') }}
                                    </a>
                                @endcan

                                @can('delete-lead')
                                    <form action="{{ route('leads.multi-operations.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="dropdown-item d-block w-100"
                                            onclick="return confirm('{{ __('messages.confirm-delete') }}')">
                                            <i class="fa fa-trash"></i>
                                            {{ __('Delete') }}
                                        </button>

                                        <input type="text" name="leads_ids" class="leads_ids_hidden_inputs d-none">
                                    </form>
                                @endcan

                            </div>
                        @endcan
                    </div>

                </div>

                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(166px, 36px, 0px);">
                    <a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a
                        class="dropdown-item" href="#">Calendar</a>
                </div>
            </div>
        @endcan

    </div>
</div>
