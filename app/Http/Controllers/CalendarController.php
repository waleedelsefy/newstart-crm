<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $this->authorize('view-calendar');

        $reminder_date = request()->get('reminder_date') ?? Carbon::now();
        $reminder_date = Carbon::parse($reminder_date)->subHours(24);

        $remindersBadges = Lead::where('assigned_to', auth()->id())
            ->whereNotNull('reminder')
            ->where(function ($query) {
                if (request()->get('reminder')) {
                    $query->where('reminder', request()->get('reminder'));
                }
            })
            ->whereDate('reminder_date', '>=', $reminder_date)
            ->selectRaw('reminder, COUNT(reminder) AS count')
            ->groupBy('reminder')->get();


        $leads = Lead::whereNotNull('reminder')->where('assigned_to', auth()->id())
            ->where(function ($query) {
                if (request()->get('reminder')) {
                    $query->where('reminder', request()->get('reminder'));
                }
            })->select(['id', 'name', 'notes', 'reminder', 'reminder_date'])->whereDate('reminder_date', '>=', $reminder_date)
            ->orderBy('reminder_date')
            ->paginate();



        return view('pages.calendar.index', [
            'leads' => $leads,
            'remindersBadges' => $remindersBadges,
        ]);
    }
}
