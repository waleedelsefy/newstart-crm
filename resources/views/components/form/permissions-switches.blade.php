@props(['name', 'permissions', 'checked_permissions' => []])

<div {{ $attributes->class([]) }}>
    <div class="row">
        @foreach ($permissions as $permission)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <x-form.switch :name="$name" :id="$permission->name" :label="$permission->display_name" :value="$permission->id"
                    :checked="in_array($permission->id, $checked_permissions)" />
            </div>
        @endforeach
    </div>
</div>
