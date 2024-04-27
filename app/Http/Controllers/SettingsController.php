<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SettingsController extends Controller
{
    public function general()
    {
        $this->authorize('view-general-settings');
        return view('pages.settings.general', ['user' => Auth::user()]);
    }

    public function security()
    {
        $this->authorize('view-security-settings');
        return view('pages.settings.security');
    }

    public function updateProfilePhoto(Request $request)
    {
        $this->authorize('view-general-settings');

        $request->validate([
            'photo' => ['required', 'image', 'max:2048']
        ]);

        try {
            $user = Auth::user();
            $user->deleteOldPhoto();
            $photo = $request->file('photo')->store('users');
            $user->update(['photo' => $photo]);
            return redirect()->back()->with('success', 'messages.updated-success');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }
}
