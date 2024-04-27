<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Throwable;

class InterestController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Interest::class, 'interest');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interests = Interest::filter(request()->query())->paginate();
        return view('pages.interests.index', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.interests.create', ['interest' =>  new Interest()]);
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
            Interest::create($request->all());
            return redirect()->route('interests.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Interest $interest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interest $interest)
    {
        return view('pages.interests.edit', ['interest' => $interest]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interest $interest)
    {
        try {
            $interest->update($request->all());
            return redirect()->route('interests.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interest $interest)
    {
        try {
            $interest->delete();
            return redirect()->route('interests.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
