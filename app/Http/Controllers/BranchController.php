<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Branch::class, 'branch');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::filter(request()->query())->latest()->paginate(5)->withQueryString();
        $availableStatus = Branch::getAvailableStatus();
        return view('pages.branches.index', compact('branches', 'availableStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.branches.create', [
            'branch' => new Branch(),
            'availableStatus' => Branch::getAvailableStatus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        try {
            Branch::create($request->all());
            return redirect()->route('branches.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            return redirect()->route('branches.index')->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('pages.branches.edit', [
            'branch' => $branch,
            'availableStatus' => Branch::getAvailableStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        try {
            $branch->update($request->all());
            return redirect()->route('branches.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            return redirect()->route('branches.index')->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            return redirect()->route('branches.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->route('branches.index')->with('error', __('messages.deleted-fail'));
        }
    }
}
