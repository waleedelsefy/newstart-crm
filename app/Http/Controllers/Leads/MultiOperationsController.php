<?php

namespace App\Http\Controllers\Leads;

use App\Events\LeadAssignedToUser;
use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Throwable;

class MultiOperationsController extends Controller
{
    private $leadsIds = [];
    private $leads = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if ($request->leads_ids) {
                $this->leadsIds = explode(',', $request->leads_ids);
            }

            if (count($this->leadsIds) <= 0) abort(401);

            if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
                $this->leads = Lead::whereIn('id', $this->leadsIds)->get();
                return $next($request);
            }

            $myLeads = auth()->user()->leadsAssignedToYouAndYourTeamsMembers();

            if ($myLeads->count() > 0) {
                $this->leads = $myLeads->whereIn('id', $this->leadsIds);
                return $next($request);
            }
        });
    }

    public function addEventView()
    {
        $this->authorize('change-lead-event');
        $events = Event::all();
        return view('pages.leads.multi-operations.add-event', compact('events'));
    }

    public function addEvent(Request $request)
    {
        $this->authorize('change-lead-event');
        $request->validate(['event_id' => ['required', 'exists:events,id']]);

        $leads = $this->leads;

        foreach ($leads as $lead) {

            $user = auth()->user();
            $newEvent = Event::find($request->event_id);
            $previousEvent = $lead->lastEvent()->event;

            $userLink = Blade::render(
                '<a href="{{route("users.show", $user)}}">{{$user->name}}</a>',
                compact("user")
            );

            $leadLink = Blade::render(
                '<a href="{{route("leads.show", $lead)}}">{{$lead->name}}</a>',
                compact("lead")
            );

            $data = [
                'type' => 'event',
                'info' => [
                    'en' => "{$userLink} changed the event on Lead {$leadLink} from {$previousEvent->name} to {$newEvent->name}",
                    'ar' => "قام {$userLink} بتغيير الحدث على العميل {$leadLink} من {$previousEvent->name} الى {$newEvent->name}"
                ],
                'user_id' => $user->id,
                'event_id' => $request->event_id,
                'previous_event' => $previousEvent->id,
                'notes' => $request->notes,
            ];

            if ($newEvent->with_notes == 'yes') {
                $rules['notes'] = ['required'];
                $request->validate($rules);
            }

            if ($newEvent->with_date == 'yes') {
                $rules['date'] = ['required'];
                $rules['time'] = ['required'];
                $request->validate($rules);
            }

            if ($request->date && $request->time) {
                $datetime = "{$request->date} {$request->time}";
                $data['reminder_date'] = \Carbon\Carbon::parse($datetime)->format('Y-m-d H:i:s');
            }

            $lead->histories()->create($data);

            // Save the event in the lead box to make statistics easy
            $lead->event_id = $lead->lastEvent()->event_id;
            $lead->event = $lead->lastEvent()->event->name;
            $lead->reminder_date = $lead->lastEvent()->reminder_date;
            $lead->event_created_by = $lead->lastEvent()->user_id;
            $lead->event_created_at = $lead->lastEvent()->created_at;
            $lead->saveQuietly();
        }

        return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.updated-success'));
    }

    public function assignToView()
    {
        $this->authorize('assign-lead-to-employee');

        // if current leads assigend to the auth user
        // he cannot assign his leads to another user
        $this->leadsIds = array_filter($this->leadsIds, function ($id) {
            $leadExists = Lead::where('id', $id)->where('assigned_to', auth()->id())->count();
            return $leadExists == 0 ? $id : null;
        });
        if (count($this->leadsIds) <= 0) abort(401);

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $users = User::availableToAssign()->get();
        } else {
            $users = User::whereIn('id', auth()->user()->teamsMembersIDs())->availableToAssign()->get();
        }

        return view('pages.leads.multi-operations.assign-to', compact('users'));
    }

    public function assignTo(Request $request)
    {
        $this->authorize('assign-lead-to-employee');

        // if current leads assigend to the auth user
        // he cannot assign his leads to another user
        $this->leadsIds = array_filter($this->leadsIds, function ($id) {
            $leadExists = Lead::where('id', $id)->where('assigned_to', auth()->id())->count();
            return $leadExists == 0 ? $id : null;
        });

        $this->leads = Lead::whereIn('id', $this->leadsIds)->get();

        foreach ($this->leads as $lead) {
            DB::beginTransaction();
            try {
                $lead->assigned_to = $request->assignable_id;
                $lead->assigned_by = auth()->id();
                $lead->assigned_at = now();
                $lead->show_old_hisory = $request->show_old_hisory == 1 ? 1 : 0;
                $lead->save();

                $assignedByUser = $lead->assignedBy;
                $assignedToUser = $lead->assignedTo;

                $assignedByUserLink = Blade::render(
                    '<a href="{{route("users.show", $assignedByUser)}}">{{$assignedByUser->name}}</a>',
                    compact("assignedByUser")
                );

                $leadLink = Blade::render(
                    '<a href="{{route("leads.show", $lead)}}">{{$lead->name}}</a>',
                    compact("lead")
                );

                if ($assignedToUser) {
                    $assignedToUserLink = Blade::render(
                        '<a href="{{route("users.show", $assignedToUser)}}">{{$assignedToUser->name}}</a>',
                        compact("assignedToUser")
                    );

                    $lead->histories()->create([
                        'type' => 'assigned',
                        'info' => [
                            'en' => "{$assignedByUserLink} assigned the lead {$leadLink} to {$assignedToUserLink}",
                            'ar' => "قام {$assignedByUserLink} بتعيين العميل {$leadLink} الى {$assignedToUserLink}"
                        ],
                        'user_id' => $assignedByUser->id,
                        'notes' => $lead->notes ?? $lead->lastEvent()->notes,
                        'event_id' => $lead->lastEvent()->event_id,
                        'previous_event' => $lead->lastEvent()->previous_event,
                    ]);

                    sleep(1);

                    $event_id = Event::where('name', 'no-action')->select('id')->first()->id;

                    $lead->histories()->create([
                        'type' => 'event',
                        'info' => [
                            'en' => "No Action",
                            'ar' => "لم يتم اتخاذ اي اجراء"
                        ],
                        'user_id' => $assignedByUser->id,
                        'notes' => NULL,
                        'event_id' => $event_id,
                        'previous_event' => $lead->lastEvent()->previous_event,
                    ]);

                    // Save the event name in the lead box to make statistics easy 
                    $lead->event_id = $event_id;
                    $lead->event = 'no-action';
                    $lead->event_created_by = $lead->lastEvent()->user_id;
                    $lead->event_created_at = $lead->lastEvent()->created_at;
                    $lead->saveQuietly();

                    LeadAssignedToUser::dispatch($lead);
                } else {
                    $lead->histories()->create([
                        'type' => 'not_assigned',
                        'info' => [
                            'en' => "{$assignedByUserLink} changed Lead {$leadLink} not assigned to anyone",
                            'ar' => "قام {$assignedByUserLink} بتغيير العميل {$leadLink} الى غير معين لأحد"
                        ],
                        'user_id' => $assignedByUser->id,
                        'notes' => $lead->notes ?? $lead->lastEvent()->notes,
                        'event_id' => $lead->lastEvent()->event_id,
                        'previous_event' => $lead->lastEvent()->previous_event,
                    ]);
                }

                DB::commit();
            } catch (Throwable $e) {
                DB::rollback();
                return redirect()->back()->with('error', __('messages.updated-fail'));
            }
        }

        if ($request->add_event == 1) {
            return redirect()->route('leads.multi-operations.add-event', ['leads_ids' => implode(',', $this->leadsIds)])
                ->with('success', __('messages.updated-success'));
        }

        return redirect()->route('leads.index', session()->get('query'))
            ->with('success', __('messages.updated-success'));
    }

    public function addSourcesView()
    {
        $this->authorize('update-lead-sources');
        $sources = Source::all();
        return view('pages.leads.multi-operations.add-sources', compact('sources'));
    }

    public function addSources(Request $request)
    {
        $this->authorize('update-lead-sources');

        $leads = $this->leads;

        foreach ($leads as $lead) {
            $sources = $request->sources_ids;
            $leadSourcesIds = $lead->sources->pluck('id')->toArray();
            $newSources = array_values(array_diff($sources, $leadSourcesIds));
            $lead->sources()->attach($newSources);
        }

        return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.updated-success'));
    }

    public function addInterestsView()
    {
        $this->authorize('update-lead-interests');
        $interests = Interest::all();
        return view('pages.leads.multi-operations.add-interests', compact('interests'));
    }

    public function addInterests(Request $request)
    {
        $this->authorize('update-lead-interests');

        $leads = $this->leads;

        foreach ($leads as $lead) {
            $interests = $request->interests_ids;
            $leadInterestsIds = $lead->interests->pluck('id')->toArray();
            $newInterests = array_values(array_diff($interests, $leadInterestsIds));
            $lead->interests()->attach($newInterests);
        }

        return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.updated-success'));
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete-lead');

        try {
            foreach ($this->leads as $lead) {
                $lead->delete();
            }
            return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
