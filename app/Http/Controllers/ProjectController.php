<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Lead;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Throwable;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::filter(request()->query())->paginate();
        $developers = Developer::all();
        return view('pages.projects.index', compact('projects', 'developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.projects.create', [
            'project' =>  new Project(),
            'developers' =>  Developer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name.*' => ['required'],
        ]);
        try {
            Project::create($request->all());
            return redirect()->route('projects.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('pages.projects.edit', [
            'project' => $project,
            'developers' =>  Developer::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $project->update($request->all());
            return redirect()->route('projects.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return redirect()->route('projects.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }

    public function ajaxProjectsByDeveloper(Request $request)
    {
        $lead = Lead::where('id', $request->lead_id)->first();
        $leadProjectsIds = $lead->projects->pluck('id')->toArray();
        $projects = Project::where('developer_id', $request->developer_id)
            ->whereNotIn('id', $leadProjectsIds)->select(['id', 'name'])->get();

        return Blade::render(
            '
                <x-form.select :select2="true" id="projects_ids" name="projects_ids[]" label="{{ __(\'Projects\') }}" multiple="multiple">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </x-form.select>
            ',
            ['projects' => $projects]
        );
    }
}
