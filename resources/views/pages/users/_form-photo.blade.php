<x-headings.h3 class="mb-2">{{ __('Update Profile Photo') }}</x-headings.h3>

<x-form.change-photo name="photo" src="{{ $user->getPhoto() }}" alt="{{ $user->username }}" />
