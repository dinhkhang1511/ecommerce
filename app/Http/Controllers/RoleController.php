<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.role.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required']);
        Role::create($data);
        return success('roles.index');
    }

    public function edit(Role $role)
    {
        return view('backend.role.edit', compact('role'));
    }

    public function update(Role $role)
    {
        $data = request()->validate(['name' => 'required']);
        $role->update($data);
        return success('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return success('roles.index');
    }
}
