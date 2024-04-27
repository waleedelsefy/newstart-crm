<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Throwable;

class SourceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Source::class, 'source');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = Source::filter(request()->query())->latest()->paginate();
        return view('pages.sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sources.create', ['source' =>  new Source()]);
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
            Source::create($request->all());
            return redirect()->route('sources.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        return view('pages.sources.edit', ['source' => $source]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        try {
            $source->update($request->all());
            return redirect()->route('sources.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        try {
            $source->delete();
            return redirect()->route('sources.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
