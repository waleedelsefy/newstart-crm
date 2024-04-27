@csrf

@if ($user->name)
    @method('PUT')
@endif



<div class="row">
    <div class="col-lg-6">
        <x-form.input :floating_group="true" name="name" placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
            :value="$user->name" />
    </div>

    {{-- <div class="col-lg-6">
        <x-form.input :floating_group="true" name="username" placeholder="{{ __('Username') }}" label="{{ __('Username') }}"
            :value="$user->username" />
    </div> --}}

    <div class="col-lg-6">
        <x-form.input type="email" :floating_group="true" name="email" placeholder="{{ __('Email') }}"
            label="{{ __('Email') }}" :value="$user->email" />
    </div>

    <div class="col-lg-6">
        <div class="row">
            <div class="col-3">
                <x-form.select :select2="true" name="country_code">
                    <option value="+20" @selected(old('country_code', $user->country_code) == '+20')>+20</option>
                    <option value="+976" @selected(old('country_code', $user->country_code) == '+976')>+976</option>
                </x-form.select>
            </div>

            <div class="col-9">
                <x-form.input :floating_group="true" icon="feather icon-phone" name="phone_number"
                    placeholder="{{ __('Phone Number') }}" label="{{ __('Phone Number') }}" :value="$user->phoneWithoutCode()" />
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <x-form.select :select2="true" name="gender" label="{{ __('Gender') }}">
            <option value="male" @selected(old('gender', $user->gender) == 'male')>{{ __('Male') }}</option>
            <option value="female" @selected(old('gender', $user->gender) == 'female')>{{ __('Female') }}</option>
        </x-form.select>
    </div>

    @can('update-user-branch')


        <div class="col-lg-6">
            <x-form.select :select2="true" name="branches_ids[]" label="{{ __('Branches') }}" multiple>

                @php
                    $userBranches = $user->branches->pluck('id')->toArray();

                    if (count($userBranches) == 0) {
                        $userBranches[] = auth()->user()->branch_id;
                    }
                @endphp

                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" @selected(in_array($branch->id, old('branches_ids', $userBranches)))>{{ $branch->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        {{-- In update page only --}}
        @if ($user->name)
            <div class="col-lg-6">
                <x-form.select :select2="true" name="branch_id" label="{{ __('Active Branch') }}">
                    @foreach ($user->branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id', $user->branch_id ?? auth()->user()->branch_id) == $branch->id)>{{ $branch->name }}</option>
                    @endforeach
                </x-form.select>
            </div>
        @endif
    @endcan

    @can('update-user-role')
        <div class="col-lg-6">
            <x-form.select :select2="true" name="role_id" label="{{ __('Role') }}">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $userRole_id ?? '') == $role->id)>{{ $role->display_name }}
                    </option>
                @endforeach
            </x-form.select>
        </div>
    @endcan

    <div class="col-lg-12">
        <x-form.textarea :floating_group="true" name="bio" placeholder="{{ __('Bio') }}"
            label="{{ __('Bio') }}" :value="$user->bio" cols="30" rows="4" />
    </div>


    @can('update-user-abilities')
        <div class="col-xl-6 mb-2">
            <x-headings.h4 class="mb-2">
                {{ __('Abilities') }}
            </x-headings.h4>

            <ul class="list-unstyled d-flex align-items-center">
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con">
                            <input type="radio" name="owner" value="0" checked>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('Nothing') }}</span>
                        </div>
                    </fieldset>
                </li>

                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con">
                            <input type="radio" name="owner" value="1" @checked($user->owner)>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('Owner') }}</span>
                        </div>
                    </fieldset>
                </li>

            </ul>

            @error('ability')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
    @endcan

    @can('update-user-permissions')
        <div class="col-xl-6 mb-2">
            <x-headings.h4 class="mb-2">
                {{ __('Active') }}
            </x-headings.h4>

            <ul class="list-unstyled d-flex align-items-center">
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con">
                            <input type="radio" name="active" value="0" checked>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('Disable') }}</span>
                        </div>
                    </fieldset>
                </li>

                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="vs-radio-con">
                            <input type="radio" name="active" value="1" @checked($user->active)>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span class="">{{ __('Enable') }}</span>
                        </div>
                    </fieldset>
                </li>

            </ul>

            @error('ability')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>


        <div class="col-12">
            <x-headings.h4 class="mb-2">
                {{ __('Permissions') }}
            </x-headings.h4>

            <div class="accordion" id="accordionExample" data-toggle-hover="true">
                @foreach ($permissions as $module => $module_permissions)
                    @php
                        $moduleUniquPrefix = Illuminate\Support\Str::slug($module);
                    @endphp

                    <div class="collapse-margin">
                        <div class="card-header" id="permissions-{{ $moduleUniquPrefix }}" data-toggle="collapse"
                            role="button" data-target="#permissions-{{ $moduleUniquPrefix }}-acc" aria-expanded="false"
                            aria-controls="permissions-{{ $moduleUniquPrefix }}-acc">
                            <span class="lead collapse-title collapsed">
                                {{ __(ucwords($module)) }}
                            </span>
                        </div>
                        <div id="permissions-{{ $moduleUniquPrefix }}-acc" class="collapse"
                            aria-labelledby="permissions-{{ $moduleUniquPrefix }}" data-parent="#accordionExample">
                            <div class="card-body">

                                <x-form.permissions-switches name="permissions[]" :permissions="$module_permissions" :checked_permissions="$user_permissions ?? []" />

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    @endcan
</div>

@if ($user->name)
    <x-buttons.success class="btn-floating" text="{{ __('Update') }}" icon="fa fa-edit" />
@else
    <x-buttons.primary class="btn-floating" text="{{ __('Create') }}" icon="fa fa-plus" />
@endif
