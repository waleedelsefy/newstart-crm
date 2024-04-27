<thead>
    <tr>
        @can('view-lead-select')
            <th scope="col">
                <input type="checkbox" class="checkbox-all-leads">
            </th>
        @endcan

        @can('view-lead-name')
            <th scope="col">{{ __('Name') }}</th>
        @endcan

        @can('view-lead-assigned-to')
            <th scope="col">
                {{ __('Assigned To') }}
            </th>
        @endcan

        @can('view-lead-projects')
            <th scope="col">{{ __('Projects') }}</th>
        @endcan

        @can('view-lead-event')
            <th scope="col">{{ __('Event') }}</th>

            <th scope="col">{{ __('Reminder') }}</th>

            <th scope="col">{{ __('Event Created By') }}</th>

            <th scope="col">{{ __('Event Created At') }}</th>
        @endcan

        @can('view-lead-notes')
            <th scope="col">{{ __('Notes') }}</th>
        @endcan

        @can('view-lead-interests')
            <th scope="col">{{ __('Interests') }}</th>
        @endcan

        @can('view-lead-sources')
            <th scope="col">{{ __('Sources') }}</th>
        @endcan

        @can('view-lead-duplicates')
            <th scope="col">{{ __('Duplicates') }}</th>
        @endcan

        @can('view-lead-phones')
            <th scope="col">{{ __('Contacts') }}</th>
        @endcan

        @can('view-lead-created-by')
            <th scope="col">{{ __('Created By') }}</th>
        @endcan

        @can('view-lead-created-at')
            <th scope="col">{{ __('Created At') }}</th>
        @endcan

        <th scope="col">{{ __('Actions') }}</th>
    </tr>
</thead>
