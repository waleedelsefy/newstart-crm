<?php

namespace App\Http\Controllers;

use App\Events\LeadAssignedToUser;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\Event;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles'])
            ->permissionsFilter()
            ->where('id', '!=', auth()->id())
            ->filter(request()->query())->with(['branch'])->latest()
            ->paginate(5)->withQueryString();
        return view('pages.users.index', [
            'users' => $users,
            'branches' => Branch::open()->get(),
            'roles' => Role::all(),
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create', [
            'user' => new User(),
            'branches' => Branch::all(),
            'roles' => Role::all(),
            'permissions' => Permission::permissionsByModule()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge(['password' => 'password']);
            // branch_id is an active branch
            $user = User::create(['branch_id' => $request->branches_ids[0], ...$request->all()]);

            // Attach branches
            $user->branches()->attach($request->branches_ids);

            $user->roles()->attach($request->role_id);
            $user->permissions()->attach($request->permissions);

            DB::commit();
            return redirect()->route('users.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.users.edit', [
            'user' => $user,
            'branches' => Branch::all(),
            'roles' => Role::all(),
            'permissions' => Permission::permissionsByModule(),
            'userRole_id' => $user->roles->pluck('id')->first(),
            'user_permissions' => $user->permissions->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update($request->all());
            $user->branches()->sync($request->branches_ids);

            /**
             * Check active branch if not in user branches after update,
             * change active branch to the first branch of the other branches.
             */
            if (!in_array($user->branch_id, $request->branches_ids)) {
                $user->update(['branch_id' => $request->branches_ids[0]]);
            }


            $user->roles()->sync($request->role_id);
            $user->permissions()->sync($request->permissions);

            DB::commit();
            return redirect()->route('users.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Update the specified resource password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        try {
            $user->update(['password' => $request->password]);
            return redirect()->back()->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Update the specified resource photo.
     */
    public function updatePhoto(Request $request, User $user)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048']
        ]);

        try {
            $user->deleteOldPhoto();
            $photo = $request->file('photo')->store('users');
            $user->update(['photo' => $photo]);
            return redirect()->back()->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->leadsAssignedToYou->count() > 0 || $user->teamsILead->count() > 0) {
                return redirect()->route('users.before-deleting', $user);
            }

            $this->someOperationsBeforeDeletingUser($user);

            $user->delete();
            return redirect()->route('users.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }

    public function beforeDeletingView(User $user)
    {
        $this->authorize('delete', $user);

        $assignToUsers = User::availableToAssign()->whereNot('id', $user->id)->get();
        $leaders = [];

        if ($user->teamsILead->count() > 0) {
            $leaders = User::whereHasRole($user->roles[0]->name)->whereNot('id', $user->id)->get();
        }

        return view('pages.users.before-deleting', compact('user', 'assignToUsers', 'leaders'));
    }

    public function beforeDeleting(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $request->validate([
            'assign_to' => ['sometimes', 'required'],
            'leader_id' => ['sometimes', 'required'],
        ]);

        // Assign old user leads to new user

        if ($user->leadsAssignedToYou->count() > 0) {

            $assignedByUser = auth()->user();
            $assignedToUser = $user;

            $assignedByUserLink = Blade::render(
                '<a href="{{route("users.show", $assignedByUser)}}">{{$assignedByUser->name}}</a>',
                compact("assignedByUser")
            );

            $assignedToUserLink = Blade::render(
                '<a href="{{route("users.show", $assignedToUser)}}">{{$assignedToUser->name}}</a>',
                compact("assignedToUser")
            );

            foreach ($user->leadsAssignedToYou as $lead) {

                $lead->assigned_to = $request->assign_to;
                $lead->assigned_by = $assignedByUser->id;
                $lead->assigned_at = now();
                $lead->save();

                $leadLink = Blade::render(
                    '<a href="{{route("leads.show", $lead)}}">{{$lead->name}}</a>',
                    compact("lead")
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
            }
        }

        // Change old user teams' leader to new leader

        if ($user->teamsILead->count() > 0) {
            foreach ($user->teamsILead as $team) {
                $team->user_id = $request->leader_id;
                $team->save();
            }
        }

        $this->someOperationsBeforeDeletingUser($user);

        $user->delete();
        return redirect()->route('users.index')->with('success', __('messages.deleted-success'));
    }

    private function someOperationsBeforeDeletingUser(User $user)
    {
        $ownerUser = User::owners()->first();

        foreach ($user->leadsAssignedByYou as $lead) {
            $lead->assigned_by = $ownerUser->id;
            $lead->saveQuietly();
        }

        foreach ($user->leadsYouCreated as $lead) {
            $lead->created_by = $ownerUser->id;
            $lead->saveQuietly();
        }

        foreach ($user->teamsICreated as $team) {
            $team->created_by = $ownerUser->id;
            $team->saveQuietly();
        }
    }
}
