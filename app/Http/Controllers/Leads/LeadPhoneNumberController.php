<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Throwable;

class LeadPhoneNumberController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Lead $lead)
    {
        $this->authorize('view-lead-phones');
        $phones = $lead->phones()->filter(request()->query())->paginate();
        return view('pages.leads.phones.index', compact('lead', 'phones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lead $lead)
    {
        // $this->authorize('create-lead-phones');
        // $phone = new PhoneNumber();
        // return view('pages.leads.phones.create', compact('lead', 'phone'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lead $lead)
    {
        // $this->authorize('create-lead-phones');
        // $request->validate(['number' => ['required', 'numeric']]);
        // try {
        //     $lead->phones()->create($request->all());
        //     return redirect()->back()->with('success', __('messages.created-success'));
        // } catch (Throwable $e) {
        //     return redirect()->back()->with('error', __('messages.created-fail'));
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead, PhoneNumber $phone)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead, PhoneNumber $phone)
    {
        // $this->authorize('update-lead-phones');
        // return view('pages.leads.phones.edit', compact('lead', 'phone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead, PhoneNumber $phone)
    {
        // $this->authorize('update-lead-phones');
        // $request->validate(['number' => ['required', 'numeric']]);
        // try {
        //     $phone->update($request->all());
        //     return redirect()->route('leads.phones.index', $lead)->with('success', __('messages.updated-success'));
        // } catch (Throwable $e) {
        //     return redirect()->back()->with('error', __('messages.updated-fail'));
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead, PhoneNumber $phone)
    {
        $this->authorize('delete-lead-phones');
        try {
            $phone->delete();
            return redirect()->back()->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
