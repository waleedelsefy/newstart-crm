<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Team::class, 'team');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with([
            'leader' => fn ($q) => $q->with(['roles']),
            'createdBy'
        ])->withCount(['members'])->permissionsFilter()->filter(request()->query())->latest()->paginate();
        return view('pages.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where(function (Builder $builder) {
            $builder
                ->marketingManagers()
                ->orWhere(fn (Builder $builder) => $builder->marketingTeamLeaders())
                ->orWhere(fn (Builder $builder) => $builder->salesManagers())
                ->orWhere(fn (Builder $builder) => $builder->salesTeamLeaders());
        })->whereHasPermission('available-for-join-to-team')->get();

        return view('pages.teams.create', [
            'team' =>  new Team(),
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:teams,name'],
            'user_id' => ['required']
        ]);
        try {
            $request->merge(['created_by' => auth()->id()]);
            Team::create($request->all());
            return redirect()->route('teams.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('pages.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $users = User::where(function (Builder $builder) use ($team) {

            if ($team->leader->hasRole('marketing-team-leader')) {
                $builder->marketingTeamLeaders();
            } elseif ($team->leader->hasRole('marketing-manager')) {
                $builder->marketingManagers();
            } elseif ($team->leader->hasRole('sales-team-leader')) {
                $builder->salesTeamLeaders();
            } elseif ($team->leader->hasRole('sales-manager')) {
                $builder->salesManagers();
            }
        })->whereHasPermission('available-for-join-to-team')->get();

        return view('pages.teams.edit', [
            'team' => $team,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => ['required', 'unique:teams,name,' . $team->id],
            'user_id' => ['required']
        ]);
        try {
            $team->update($request->all());
            return redirect()->route('teams.index', ['leader' => request()->get('leader')])->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        try {
            $team->delete();
            return redirect()->route('teams.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }

    public function members(Team $team)
    {
        $this->authorize('update', $team);

        $employees = User::where('id', '!=', $team->user_id)->whereHasPermission('available-for-join-to-team');

        if ($team->leader->hasRole('marketing-team-leader'))
            $employees = $employees->marketing()->get();

        if ($team->leader->hasRole('marketing-manager'))
            $employees = $employees->marketingTeamLeaders()->get();

        if ($team->leader->hasRole('sales-team-leader'))
            $employees = $employees->sales()->get();

        if ($team->leader->hasRole('sales-manager'))
            $employees = $employees->salesTeamLeaders()->get();

        return view('pages.teams.members', compact('team', 'employees'));
    }

    public function updateMembers(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $request->validate([
            'members' => ['required'],
            'members.*' => ['required', 'exists:users,id'],
        ]);

        try {
            $members = [];

            foreach ($request->members as $member)
                $members[$member] = ['added_by' => auth()->id()];

            $team->members()->sync($members);

            return redirect()->route('teams.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }
}
