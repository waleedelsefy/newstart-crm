<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::filter(request()->query())->latest()->paginate(5)->withQueryString();
        return view('pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.create', [
            'role' => new Role(),
            'permissions' => Permission::permissionsByModule()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create($request->except(['permissions']));
            $role->permissions()->attach($request->permissions);
            DB::commit();
            return redirect()->route('roles.index')->with('success', __('messages.created-success'));
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.created-fail'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('pages.roles.edit', [
            'role' => $role,
            'permissions' => Permission::permissionsByModule(),
            'role_permissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        DB::beginTransaction();
        try {
            $role->update($request->except(['permissions']));
            $role->permissions()->sync($request->permissions);
            DB::commit();
            return redirect()->route('roles.index')->with('success', __('messages.updated-success'));
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('messages.updated-fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', __('messages.deleted-success'));
        } catch (Throwable $e) {
            return redirect()->back()->with('error', __('messages.deleted-fail'));
        }
    }
}
