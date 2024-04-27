@csrf

@if ($team->name)
    @method('PUT')
@endif



<div class="row">
    <div class="col-lg-12">
        <x-form.input :floating_group="true" name="name" placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
            :value="$team->name" />
    </div>

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="description" placeholder="{{ __('Description') }}"
            label="{{ __('Description') }}" :value="$team->description" cols="30" rows="4" />
    </div>

    <div class="col-lg-12">
        <x-form.select :select2="true" name="user_id" label="{{ __('Leader') }}">
            <option value="">{{ __('Select') }}</option>

            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $team->leader->id ?? '') == $user->id)>
                    [ {{ $user->jobTitle() }} ] {{ $user->name }}
                </option>
            @endforeach
        </x-form.select>
    </div>

</div>

@if ($team->name)
    <x-buttons.success text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
