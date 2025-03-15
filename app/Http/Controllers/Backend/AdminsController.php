<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.view']);

        $user = auth()->user();
        $admins = collect(); // Default empty collection

        if ($user->hasRole('superadmin')) {
            // Superadmin sees all admins
            $admins = Admin::all();
        } elseif ($user->hasRole('admin')) {
            // Admin sees only Managers they created
            $admins = Admin::where('created_by', $user->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'manager');
                })->get();
        } elseif ($user->hasRole('manager')) {
            // Manager sees only Employees they created
            $admins = Admin::where('created_by', $user->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'employee');
                })->get();
        } elseif ($user->hasRole('employee')) {
            // Employee sees only their own profile
            $admins = Admin::where('id', $user->id)->get();
        }

        return view('backend.pages.admins.index', compact('admins'));
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.create']);

        $user = auth()->user();
        $roles = collect();
        if ($user->hasRole('superadmin')) {
            $roles = Role::all();
        } elseif ($user->hasRole('admin')) {
            $roles = Role::whereIn('name', ['manager', 'employee'])->get();
        } elseif ($user->hasRole('manager')) {
            $roles = Role::where('name', 'employee')->get();
        }

        return view('backend.pages.admins.create', [
            'roles' => $roles,
        ]);
    }


    public function store(AdminRequest $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['admin.create']);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->created_by = auth()->id();
        $admin->save();

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', __('Admin has been created.'));
        return redirect()->route('admin.admins.index');
    }

    public function edit(int $id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        $admin = Admin::findOrFail($id);
        $user = auth()->user();
        $roles = collect();
        if (
            $user->hasRole('superadmin') ||
            ($user->hasRole('admin') && $admin->parent_id == $user->id) ||
            ($user->hasRole('manager') && $admin->parent_id == $user->id)
        ) {
            if ($user->hasRole('superadmin')) {
                $roles = Role::all();
            } elseif ($user->hasRole('admin')) {
                $roles = Role::whereIn('name', ['manager', 'employee'])->get();
            } elseif ($user->hasRole('manager')) {
                $roles = Role::where('name', 'employee')->get();
            }

            return view('backend.pages.admins.edit', [
                'admin' => $admin,
                'roles' => $roles,
            ]);
        }

        abort(403, 'Unauthorized');
    }


    public function update(AdminRequest $request, int $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        $admin->roles()->detach();
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', 'Admin has been updated.');
        return back();
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['admin.delete']);

        $admin = Admin::findOrFail($id);
        $admin->delete();
        session()->flash('success', 'Admin has been deleted.');
        return back();
    }
}
