<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Throwable;

class DeveloperController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Developer::class, 'developer');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = Developer::filter(request()->query())->paginate();
        return view('pages.developers.index', compact('developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.developers.create', ['developer' =>  new Developer()]);
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
            Developer::create($request->all());
            return redirect()->route('developers.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Developer $developer)
    {
        return view('pages.developers.edit', ['developer' => $developer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        try {
            $developer->update($request->all());
            return redirect()->route('developers.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        try {
            $developer->delete();
            return redirect()->route('developers.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
