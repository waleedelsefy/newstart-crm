<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Throwable;

class EventController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::filter(request()->query())->latest()->paginate();
        return view('pages.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.events.create', ['event' =>  new Event()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:events,name'],
        ]);
        try {
            Event::create($request->all());
            return redirect()->route('events.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('pages.events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => ['required', 'unique:events,name,' . $event->id],
        ]);
        try {
            $request->merge([
                'with_date' => $request->with_date == 'yes' ? 'yes' : 'no',
                'with_notes' => $request->with_notes == 'yes' ? 'yes' : 'no',
            ]);
            $event->update($request->all());
            return redirect()->route('events.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return redirect()->route('events.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
