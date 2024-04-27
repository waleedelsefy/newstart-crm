@php
    $without_search = $without_search ?? false;
@endphp


<form action="">
    <div class="scrollable-leads-filter mb-1">
        <div class="scrollable-wrapper">

            @if (!$without_search)
                <div class="scrollable-slide">
                    <x-form.input name="search" label="{{ __('Search') }}" placeholder="{{ __('Search') }}"
                        value="{{ request()->get('search') }}" />
                </div>
            @endif

            <div class="scrollable-slide">
                <div class="form-group">
                    <label for="from_date">{{ __('From Date') }}</label>
                    <input type="date" name="from_date" id="from_date" class="form-control"
                        value="{{ request()->get('from_date') }}">
                </div>
            </div>

            <div class="scrollable-slide">
                <div class="form-group">
                    <label for="from_time">{{ __('From Time') }}</label>
                    <input type="time" name="from_time" id="from_time" class="form-control"
                        value="{{ request()->get('from_time') }}">
                </div>
            </div>

            <div class="scrollable-slide">
                <div class="form-group">
                    <label for="to_date">{{ __('To Date') }}</label>
                    <input type="date" name="to_date" id="to_date" class="form-control"
                        value="{{ request()->get('to_date') }}">
                </div>
            </div>

            <div class="scrollable-slide">
                <div class="form-group">
                    <label for="to_time">{{ __('To Time') }}</label>
                    <input type="time" name="to_time" id="to_time" class="form-control"
                        value="{{ request()->get('to_time') }}">
                </div>
            </div>
        </div>
    </div>


    <x-buttons.primary text="{{ __('Search') }}" icon="feather icon-search" />
    <x-buttons.light href="{{ url()->current() }}" text="{{ __('Reset') }}" icon="feather icon-loader" />
</form>
