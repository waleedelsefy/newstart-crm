@props(['lead', 'users', 'assignable_id' => ''])


<form action="{{ route('leads.assign', ['lead' => $lead]) }}" method="POST">
    @csrf
    @method('PATCH')

    <x-form.select :select2="true" name="assignable_id" id="assignable_id" label="{{ __('User') }}"
        onchange="this.form.submit()" style="display: block">

        @if (auth()->user()->owner)
            <option value="">{{ __('All') }}</option>
        @endif

        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected($user->id == $assignable_id)>
                {{ $user->username }}
            </option>
        @endforeach
    </x-form.select>

    <div class="col-12">
        <x-form.switch name="show_old_hisory" label="{{ __('Show the old history?') }}" value="1" />
    </div>
</form>
