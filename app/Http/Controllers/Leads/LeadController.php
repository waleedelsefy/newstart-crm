<?php

namespace App\Http\Controllers\Leads;

use App\Events\LeadAssignedToUser;
use App\Exports\LeadsExport;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Imports\LeadsImport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Jobs\NotifyUserOfCompletedImport;
use App\Models\Branch;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\PhoneNumber;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Lead::class, 'lead');
    }

    public function index()
    {
        session()->put('query', null);
        $queryString = request()->getQueryString();
        if ($queryString)
            session()->put('query', $queryString);

        $leads = Lead::permissionsFilter()->filter(request()->query())
            ->with(['interests', 'sources', 'projects', 'phones', 'histories', 'assignedTo', 'createdBy', 'eventCreatedBy'])
            ->latest()->paginate(50)->withQueryString();

        $leadsCount = Lead::permissionsFilter()->filter(request()->query())->count();

        $branches = Branch::all(['id', 'name']);
        $sources = Source::all(['id', 'name']);
        $interests = Interest::all(['id', 'name']);
        $projects = Project::select(['id', 'name', 'developer_id'])->with(['developer' => fn ($q) => $q->select(['id', 'name'])])->get();
        $events = Event::all(['id', 'name']);

        // $users = User::with('roles');
        // if (in_array(request()->get('assigned_to'), ['my_team', 'me_my_team'])) {
        //     $users->whereIn('id', auth()->user()->teamsMembersIDs());
        // }

        // return $users->get();

        $usersAvailableToAssign = [];

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $usersAvailableToAssign = User::availableToAssign();
        } else {
            $usersAvailableToAssign = User::whereIn('id', auth()->user()->teamsMembersIDs())->availableToAssign();
        }

        $usersAvailableToAssign =  $usersAvailableToAssign->with(['roles'])->select(['id', 'username'])->get();
        $usersSalesTeamLeaders = User::everySalesLeader()->with(['roles'])->select(['id', 'username'])->get();

        $creators = [];

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $creators = User::canCreateLeads();
        } else {
            $creators = User::whereIn('id', auth()->user()->teamsMembersIDs());
        }
        $creators =  $creators->with(['roles'])->select(['id', 'username'])->get();

        return view('pages.leads.index', [
            'leads' => $leads,
            'leadsCount' => $leadsCount,
            'branches' => $branches,
            'sources' => $sources,
            'interests' => $interests,
            'projects' => $projects,
            'events' => $events,
            // 'users' => $users,
            'usersAvailableToAssign' => $usersAvailableToAssign,
            'usersSalesTeamLeaders' => $usersSalesTeamLeaders,
            'usersCanAssignLeadsToEmployees' => User::canAssignLeadsToEmployees()->with(['roles'])->select(['id', 'username'])->get(),
            'creators' => $creators,

            'queryString' => $queryString,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.leads.create');
        return view('pages.leads.create', [
            'lead' =>  new Lead(),
            'interests' => Interest::all(),
            'sources' => Source::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $request)
    {
        $request->validate([
            'name' => ['required'],
            'interests_ids' => ['required'],
            'sources_ids' => ['required'],
            'numbers.*' => ['required'],
        ]);


        DB::beginTransaction();
        try {
            $numbers = array_filter($request->numbers);

            $lead = Lead::create($request->all());
            $lead->sources()->attach($request->sources_ids);
            $lead->interests()->attach($request->interests_ids);

            foreach ($numbers as $number) {
                PhoneNumber::create([
                    'callable_type' => 'App\Models\Lead',
                    'callable_id' => $lead->id,
                    'number' => Str::remove(' ', $number) // remove spaces,
                ]);
            }

            DB::commit();
            return redirect()->route('leads.projects.create', $lead)->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {


        // $test = explode(' ', $lead->notes);
        // dd($test);

        // session()->put('query', null);
        $lead = Lead::with([
            'projects' => fn ($q) => $q->with(['developer']),
        ])->find($lead->id);

        $histories = $lead->histories()->with(['user']);



        if ($lead->show_old_hisory == 0 && auth()->user()->owner == 0) {
            $histories->whereIn('user_id', [auth()->id(), ...auth()->user()->teamsMembersIDs()]);
        }

        // if (!auth()->user()->canViewAllLeadHistory()) {
        // }

        $histories = $histories->paginate(5);
        return view('pages.leads.show', compact('lead', 'histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        return view('pages.leads.edit', compact('lead'));
        return view('pages.leads.edit', [
            'lead' => $lead,
            'interests' => Interest::all(),
            'sources' => Source::all(),
            'branches' =>  Branch::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRequest $request, Lead $lead)
    {
        $request->validate([
            'name' => ['required'],
            'interests_ids' => ['sometimes', 'required'],
            'sources_ids' => ['sometimes', 'required'],
            'numbers.*' => ['sometimes', 'required'],
        ]);

        DB::beginTransaction();
        try {
            $lead->update($request->all());

            if ($request->sources_ids)
                $lead->sources()->sync($request->sources_ids);

            if ($request->interests_ids)
                $lead->interests()->sync($request->interests_ids);

            if ($request->numbers) {
                $numbers = array_filter($request->numbers);

                $lead->phones()->delete();
                foreach ($numbers as $number) {
                    PhoneNumber::create([
                        'callable_type' => 'App\Models\Lead',
                        'callable_id' => $lead->id,
                        'number' => $number,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('leads.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            dd($e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
            return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }

    public function assignToModal(Request $request, Lead $lead)
    {
        $this->authorize('assign-lead-to-employee');

        $users = [];

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $users = User::availableToAssign()->get();
        } else {
            $users = User::whereIn('id', auth()->user()->teamsMembersIDs())->availableToAssign()->get();
        }

        $content = Blade::render('<x-modals.content.assign-to-form :lead="$lead" :users="$users" :assignable_id="$assignable_id" />', [
            'lead' => $lead,
            'users' => $users,
            'assignable_id' => $request->assignable_id,
        ]);

        return Blade::render('<x-modals.general :title="$title" :content="$content" />', [
            'title' => __('Assign') . " [ {$lead->name} ] " . __('to'),
            'content' => $content,
        ]);
    }

    public function assignTo(Request $request, Lead $lead)
    {
        $this->authorize('assign-lead-to-employee');

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
            return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            DB::rollback();
            // dd($e->getMessage());
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    public function editEvent(Lead $lead)
    {
        $this->authorize('changeLeadEvent', $lead);
        $events = Event::all();
        return view('pages.leads.edit-event', compact('lead', 'events'));
    }

    public function updateEvent(Request $request, Lead $lead)
    {
        $this->authorize('changeLeadEvent', $lead);
        $request->validate(['event_id' => ['required', 'exists:events,id']]);

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


        return redirect()->route('leads.index', session()->get('query'))->with('success', __('messages.updated-success'));
    }

    public function duplicates(Lead $lead)
    {
        $this->authorize('viewLeadDuplicates', $lead);
        $leads = Lead::whereHas('phones', function ($q) use ($lead) {
            $q->where('number', $lead->phones->first()?->number);
        })->latest()->paginate(5);
        return view('pages.leads.duplicates', compact('leads'));
    }

    public function import(Request $request)
    {
        $this->authorize('import-lead-excel');

        $request->validate([
            'excel_file' => 'required|mimes:xlsx, csv, xls'
        ]);

        Storage::putFileAs('/', $request->file('excel_file'), 'leads.xlsx');

        Excel::queueImport(new LeadsImport(auth()->user()), 'leads.xlsx')->chain([
            new NotifyUserOfCompletedImport(auth()->user()),
        ]);

        return redirect()->route('leads.index')->with('success', __('messages.import-start'));
    }

    public function export()
    {
        $this->authorize('export-lead-excel');

        (new LeadsExport(auth()->user()))
            ->queue('leads.xlsx')
            ->chain([
                new NotifyUserOfCompletedExport(auth()->user()),
            ]);
        return redirect()->route('leads.index')->with('success', __('messages.export-start'));
    }

    public function exportDownload()
    {
        $this->authorize('export-lead-excel');

        return Storage::download('leads.xlsx');
    }
}
