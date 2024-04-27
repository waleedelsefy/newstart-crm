@csrf

@php
    $inUpdateMode = false;
@endphp

@if ($lead->name)
    @method('PUT')

    @php
        $inUpdateMode = true;
    @endphp
@endif

@push('styles')
    <style>
        .phones-fields .phones-container .phone-field {
            position: relative;
        }

        .phones-fields .phones-container .phone-field .remove-phone-field {
            position: absolute;
            right: -25px;
            top: 8px;
            width: 20px;
            height: 20px;
            display: block;
            z-index: 1;
            cursor: pointer;
            background: #ea5455;
            color: #fff;
            border-radius: 4px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phones-fields .add-phone-field {
            /* display: block; */

        }
    </style>
@endpush



<div class="row">

    @if ($inUpdateMode)
        @can('update-lead-branch')
            <div class="col-lg-4">
                <x-form.select :select2="true" name="branch_id" label="{{ __('Branch') }}">
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id', $lead->branch_id) == $branch->id)>{{ $branch->name }}</option>
                    @endforeach
                </x-form.select>
            </div>
        @endcan
    @endif

    @if ($inUpdateMode)
        @can('update-lead-name')
            <div class="col-lg-12">
                <x-form.input :floating_group="true" name="name" :placeholder="__('Name')" :label="__('Name')" :value="$lead->name" />
            </div>
        @endcan
    @else
        <div class="col-lg-12">
            <x-form.input :floating_group="true" name="name" :placeholder="__('Name')" :label="__('Name')" :value="$lead->name" />
        </div>
    @endif

    @if ($inUpdateMode)
        @can('update-lead-notes')
            <div class="col-lg-12">
                <x-form.textarea :floating_group="true" id="editor" name="notes" placeholder="{{ __('Notes') }}"
                    label="{{ __('Notes') }}" :value="$lead->notes" cols="30" rows="4" />
            @endcan
        @else
            <div class="col-lg-12">
                <x-form.textarea :floating_group="true" id="editor" name="notes" placeholder="{{ __('Notes') }}"
                    label="{{ __('Notes') }}" :value="$lead->notes" cols="30" rows="4" />
    @endif

</div>

@if ($inUpdateMode)
    @can('update-lead-interests')
        <div class="col-lg-6">
            <x-form.select :select2="true" name="interests_ids[]" label="{{ __('Interests') }}" multiple="multiple">
                @foreach ($interests as $interest)
                    <option value="{{ $interest->id }}" @selected(in_array($interest->id, old('interests_ids', [])) || in_array($interest->id, $lead->interests->pluck('id')->toArray()))>{{ $interest->name }}</option>
                @endforeach
            </x-form.select>
        </div>
    @endcan
@else
    <div class="col-lg-6">
        <x-form.select :select2="true" name="interests_ids[]" label="{{ __('Interests') }}" multiple="multiple">
            @foreach ($interests as $interest)
                <option value="{{ $interest->id }}" @selected(in_array($interest->id, old('interests_ids', [])) || in_array($interest->id, $lead->interests->pluck('id')->toArray()))>{{ $interest->name }}</option>
            @endforeach
        </x-form.select>
    </div>
@endif

@if ($inUpdateMode)
    @can('update-lead-sources')
        <div class="col-lg-6">
            <x-form.select :select2="true" name="sources_ids[]" label="{{ __('Sources') }}" multiple="multiple">
                @foreach ($sources as $source)
                    <option value="{{ $source->id }}" @selected(in_array($source->id, old('sources_ids', [])) || in_array($source->id, $lead->sources->pluck('id')->toArray()))>{{ $source->name }}</option>
                @endforeach
            </x-form.select>
        </div>
    @endcan
@else
    <div class="col-lg-6">
        <x-form.select :select2="true" name="sources_ids[]" label="{{ __('Sources') }}" multiple="multiple">
            @foreach ($sources as $source)
                <option value="{{ $source->id }}" @selected(in_array($source->id, old('sources_ids', [])) || in_array($source->id, $lead->sources->pluck('id')->toArray()))>{{ $source->name }}</option>
            @endforeach
        </x-form.select>
    </div>
@endif


<div class="col-lg-6">
    <div class="phones-fields">
        <div class="phones-container w-100">
            @can('update-lead-phones')
                @if ($lead->phones->count() > 0)
                    @foreach ($lead->phones as $phone)
                        <div class="phone-field">

                            @if (!$loop->first)
                                <span class="remove-phone-field">
                                    <i class="feather icon-x"></i>
                                </span>
                            @endif


                            <x-form.input :floating_group="true" icon="feather icon-phone" name="numbers[]"
                                placeholder="{{ __('Phone Number') }}" label="{{ __('Phone Number') }}"
                                value="{{ $phone->number }}" style="direction: ltr" />
                        </div>
                    @endforeach
                @endif
            @endcan


            @if ($lead->phones->count() == 0)
                {{-- If there's no phones that means we are in create lead page not update page --}}
                <div class="phone-field" data-id="phone-field-0">
                    <x-form.input :floating_group="true" icon="feather icon-phone" name="numbers[]"
                        placeholder="{{ __('Phone Number') }}" label="{{ __('Phone Number') }}" value=""
                        style="direction: ltr" />
                </div>
            @endif


        </div>

        @can('update-lead-phones')
            @if ($lead->phones->count() > 0)
                <span class="add-phone-field btn btn-sm btn-success mb-2">
                    <i class="feather icon-plus"></i>
                </span>
            @endif
        @endcan

        @if ($lead->phones->count() == 0)
            <span class="add-phone-field btn btn-sm btn-success mb-2">
                <i class="feather icon-plus"></i>
            </span>
        @endif
    </div>

    <div id="base-phone-field" class="d-none">

        <div class="phone-field">
            <span class="remove-phone-field">
                <i class="feather icon-x"></i>
            </span>

            <x-form.input :floating_group="true" icon="feather icon-phone" placeholder="{{ __('Phone Number') }}"
                name="" label="{{ __('Phone Number') }}" value="" style="direction: ltr" />
        </div>
    </div>

</div>

</div>

@if ($inUpdateMode)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif


@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>


    <script>
        const phonesFieldsContainer = document.querySelector('.phones-fields .phones-container');
        const addPhoneField = document.querySelector('.add-phone-field');

        const maxFields = 3;
        let fieldsCount = 1;

        initFields();

        addPhoneField.addEventListener('click', addField);

        function initFields() {
            const phonesFields = document.querySelectorAll('.phones-fields .phones-container .phone-field');
            fieldsCount = phonesFields.length;

            if (fieldsCount == maxFields) addPhoneField.classList.add('d-none');

            phonesFields.forEach(field => {
                removeFieldOnClick(field);
            });
        }

        function removeFieldOnClick(field) {
            const removePhoneField = field.querySelector('.remove-phone-field');
            if (removePhoneField != undefined) {
                removePhoneField.addEventListener('click', function() {
                    field.remove();
                    initFields();
                    if (fieldsCount < maxFields) addPhoneField.classList.remove('d-none');
                })
            }
        }

        function addField() {
            if (fieldsCount == maxFields) return;
            if (fieldsCount == maxFields - 1) addPhoneField.classList.add('d-none');

            const basePhoneField = document.getElementById('base-phone-field');
            const cloneOf_basePhoneField = basePhoneField.children[0].cloneNode(true);
            cloneOf_basePhoneField.classList.remove('d-none');
            cloneOf_basePhoneField.querySelector('input').value = "";
            cloneOf_basePhoneField.querySelector('input').name = "numbers[]";
            phonesFieldsContainer.append(cloneOf_basePhoneField);
            initFields();
        }
    </script>
@endpush
