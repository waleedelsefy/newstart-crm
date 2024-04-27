<tbody>
    @foreach ($leads as $lead)
        <tr
            style="background: {{ $lead->duplicates() > 0 &&auth()->user()->hasPermissions(['view-lead-duplicates'])? '#7367f00d': '' }}">
            @can('view-lead-select')
                <td>
                    <input type="checkbox" name="selected_leads[]" class="lead-checkbox" value="{{ $lead->id }}">
                </td>
            @endcan


            @can('view-lead-name')
                <td>
                    <a href="{{ route('leads.show', $lead) }}">
                        {{ $lead->name }}
                    </a>
                </td>
            @endcan

            @can('view-lead-assigned-to')
                <td>
                    @if ($lead->assignedTo)
                        <a href="{{ route('users.show', $lead->assignedTo) }}" class="chip">
                            <div class="chip-body">
                                <div class="avatar">
                                    <img class="img-fluid" src="{{ $lead->assignedTo->getPhoto() }}"
                                        alt="{{ $lead->assignedTo->username }}">
                                </div>
                                <span class="chip-text">{{ $lead->assignedTo->username }}</span>
                            </div>
                        </a>

                        @can('assign-lead-to-employee')
                            @if ($lead->assignedTo->id != auth()->id())
                                <x-buttons.primary
                                    data-url="{{ route('leads.assign', ['lead' => $lead, 'assignable_id' => $lead->assignedTo?->id]) }}"
                                    text="" icon="fa fa-edit" class="assign-to btn-xs" />
                            @endif
                        @endcan
                    @else
                        <x-badges.light text="{{ __('No One') }}" />

                        @can('assign-lead-to-employee')
                            <x-buttons.primary
                                data-url="{{ route('leads.assign', ['lead' => $lead, 'assignable_id' => $lead->assignedTo?->id]) }}"
                                text="" icon="fa fa-edit" class="assign-to btn-xs" />
                        @endcan
                    @endif
                </td>
            @endcan

            @can('view-lead-projects')
                <td>
                    {{ $lead->projects->count() ? $lead->projects->implode('name', ', ') : __('Unknown') }}
                </td>
            @endcan

            @can('view-lead-event')
                <td>
                    @if ($lead->event == 'fresh')
                        <x-badges.light text="{{ $lead->event }}" />
                    @elseif($lead->event == 'no-action')
                        <x-badges.info text="{{ $lead->event }}" />
                    @else
                        <x-badges.success text="{{ $lead->event }}" />
                    @endif

                    {{-- @if ($lead->lastEvent()->event->name == 'fresh')
                        <x-badges.light text="{{ $lead->lastEvent()->event->name }}" />
                    @elseif($lead->lastEvent()->event->name == 'no-action')
                        <x-badges.info text="{{ $lead->lastEvent()->event->name }}" />
                    @else
                        <x-badges.success text="{{ $lead->lastEvent()->event->name }}" />
                    @endif --}}

                    @can('changeLeadEvent', $lead)
                        <x-buttons.primary href="{{ route('leads.event', ['lead' => $lead]) }}" text=""
                            icon="fa fa-edit" class="add-event btn-xs" />
                    @endcan
                </td>

                <td>
                    @if ($lead->reminder == 'today')
                        <x-badges.success text="{{ strtoupper($lead->reminder) }}" />
                    @elseif($lead->reminder == 'upcoming')
                        <x-badges.primary text="{{ strtoupper($lead->reminder) }}" />
                    @elseif($lead->reminder == 'delay')
                        <x-badges.danger text="{{ strtoupper($lead->reminder) }}" />
                    @else
                        <x-badges.light text="{{ __('Nothing') }}" />
                    @endif
                </td>

                <td>
                    @if ($lead->eventCreatedBy)
                        <a href="{{ route('users.show', $lead->eventCreatedBy) }}" class="chip">
                            <div class="chip-body">
                                <div class="avatar">
                                    <img class="img-fluid" src="{{ $lead->eventCreatedBy->getPhoto() }}"
                                        alt="{{ $lead->eventCreatedBy->username }}">
                                </div>
                                <span class="chip-text">{{ $lead->eventCreatedBy->username }}</span>
                            </div>
                        </a>
                    @else
                        <x-badges.light text="{{ __('No One') }}" />
                    @endif

                    {{-- @if ($lead->lastEvent()->user)
                    <a href="{{ route('users.show', $lead->lastEvent()->user) }}" class="chip">
                        <div class="chip-body">
                            <div class="avatar">
                                <img class="img-fluid" src="{{ $lead->lastEvent()->user->getPhoto() }}"
                                    alt="{{ $lead->lastEvent()->user->username }}">
                            </div>
                            <span class="chip-text">{{ $lead->lastEvent()->user->username }}</span>
                        </div>
                    </a>
                @else
                    <x-badges.light text="{{ __('No One') }}" />
                @endif --}}
                </td>

                <td>
                    {{ $lead->event_created_at }}
                </td>
            @endcan

            @can('view-lead-notes')
                <td>
                    @php
                        $notes = $lead->histories->where('type', 'event')->first()->notes ?? ($lead->notes ?? '');
                    @endphp

                    {{ $notes ? Str::limit(strip_tags($notes), 20, '...') : __('Nothing') }}

                    {{-- {{ $lead->lastEvent()->notes ? Str::limit(strip_tags($lead->lastEvent()->notes), 20, '...') : __('Nothing') }} --}}
                </td>
            @endcan

            @can('view-lead-interests')
                <td>
                    {{ $lead->interests->count() ? $lead->interests->implode('name', ', ') : __('Unknown') }}
                </td>
            @endcan

            @can('view-lead-sources')
                <td>
                    {{ $lead->sources->count() ? $lead->sources->implode('name', ', ') : __('Unknown') }}
                </td>
            @endcan

            @can('viewLeadDuplicates', $lead)
                <td>
                    @if ($lead->duplicates() > 0)
                        <a href="{{ route('leads.duplicates', $lead) }}">
                            <x-badges.primary text="{{ $lead->duplicates() }}" icon="feather icon-eye" />
                        </a>
                    @else
                        <x-badges.light text="{{ $lead->duplicates() }}" icon="feather icon-eye" />
                    @endif
                </td>
            @else
                <td>{{ __('Unknown') }}</td>
            @endcan

            @can('view-lead-phones')
                <td>
                    <x-buttons.primary text="" icon="fa fa-address-book" class="btn-sm" title="{{ __('Contacts') }}"
                        type="button" data-toggle="modal" data-target="#leads-{{ $lead->id }}-contacts-model" />

                    @include('pages.leads.partials._leads-contacts-model', ['lead' => $lead])
                </td>
            @endcan


            @can('view-lead-created-by')
                <td>
                    @if ($lead->createdBy)
                        <a href="{{ route('users.show', $lead->createdBy) }}" class="chip">
                            <div class="chip-body">
                                <div class="avatar">
                                    <img class="img-fluid" src="{{ $lead->createdBy->getPhoto() }}"
                                        alt="{{ $lead->createdBy->username }}">
                                </div>
                                <span class="chip-text">{{ $lead->createdBy->username }}</span>
                            </div>
                        </a>
                    @else
                        <x-badges.light text="{{ __('No One') }}" />
                    @endif
                </td>
            @endcan

            @can('view-lead-created-at')
                <td>
                    {{ $lead->created_at }}
                </td>
            @endcan



            <td>
                <div class="d-flex flex-wrap" style="gap: 5px">

                    @can('view-lead-phones')
                        <x-buttons.info href="{{ route('leads.phones.index', $lead) }}" text="" icon="fa fa-phone"
                            class="btn-sm" title="{{ __('Phones') }}" />
                    @endcan

                    @can('view-lead-projects', \App\Models\Lead::class)
                        <x-buttons.warning href="{{ route('leads.projects.index', $lead) }}" text=""
                            icon="fa fa-map" class="btn-sm" title="{{ __('Projects') }}" />
                    @endcan

                    @can('update', $lead)
                        <x-buttons.success href="{{ route('leads.edit', $lead) }}" text="" icon="fa fa-edit"
                            class="btn-sm" title="{{ __('Edit') }}" />
                    @endcan

                    @can('delete', $lead)
                        <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')

                            <x-buttons.danger text=""
                                onclick="return confirm('{{ __('messages.confirm-delete') }}')" icon="fa fa-trash"
                                class="btn-sm" title="{{ __('Delete') }}" />
                        </form>
                    @endcan
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
