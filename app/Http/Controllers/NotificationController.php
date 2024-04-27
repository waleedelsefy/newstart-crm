<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate();
        return view('pages.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        if (is_null($notification->read_at))
            $notification->markAsRead();

        // Add local to url that comes from database.
        $url = $notification->url;

        if (strpos($url, '/en/') == false && strpos($url, '/ar/') == false) {
            $url = str_replace(config('app.url'), '', $notification->url);
            $url = config('app.url') . '/' . app()->getLocale() . $url;
        }

        return redirect()->secure($url);
    }

    public function send()
    {
        $user = Auth::user();
        $teamsILead = $user->teamsILead;

        $users = [];

        if ($user->owner) {
            $users = User::with(['roles'])->get(['id', 'username']);
        } elseif ($user->teamsILead->count() > 0) {
            $users = User::with(['roles'])->whereIn('id', $user->teamsMembersIDs())->get(['id', 'username']);
        }

        return view('pages.notifications.send', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required'],
            'url' => ['nullable', 'url'],
            'send_to_all' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();
        $users = [];

        if ($request->send_to_all == 1) {

            if ($user->owner) {
                $users = User::get(['id', 'username']);
            } elseif ($user->teamsILead->count() > 0) {
                $users = User::whereIn('id', $user->teamsMembersIDs())->get(['id', 'username']);
            }
        } else {
            $users = User::whereIn('id', $request->users_ids ?? [])->get(['id', 'username']);
        }

        $options = [
            'title' => [
                'en' => $user->username,
                'ar' => $user->username,
            ],
            'description' => [
                'en' => [
                    $request->message,
                ],
                'ar' => [
                    $request->message
                ]
            ],
            'image' => $user->getPhoto(),
            'url' => $request->url,
            'color' => 'primary',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($options));
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
