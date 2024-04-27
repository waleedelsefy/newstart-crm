<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Lead;
use App\Models\Project;
use Illuminate\Http\Request;
use Throwable;

class LeadProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Lead $lead)
    {
        $this->authorize('view-lead-projects');
        $projects = $lead->projects()->paginate();
        return view('pages.leads.projects.index', compact('projects', 'lead'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lead $lead)
    {
        $this->authorize('create-lead-projects');
        return view('pages.leads.projects.create', [
            'lead' => $lead,
            'project' => new Project(),
            'developers' => Developer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lead $lead)
    {
        $this->authorize('create-lead-projects');

        $request->validate(['projects_ids' => ['required', 'array']]);

        try {
            $lead->projects()->attach($request->projects_ids);
            return redirect()->back()->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead, Project $project)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead, Project $project)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead, Project $project)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead, Project $project)
    {
        $this->authorize('delete-lead-projects');
        try {
            $lead->projects()->detach($project->id);
            return redirect()->route('leads.projects.index', $lead)->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
