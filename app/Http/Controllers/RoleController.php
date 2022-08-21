<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Cookie;

class RoleController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('roles',request()->all());
        $roles = $data->roles;
        return view('backend.role.index', compact('roles','data'));
    }

    public function create()
    {
        return view('backend.role.create');
    }

    public function store()
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $data = request()->validate(['name' => 'required']);
        $response = HttpService()->postDataWithBody('roles',$data,$headers);

        return success('roles.index');
    }

    public function edit(Role $role)
    {
        return view('backend.role.edit', compact('role'));
    }

    public function update($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $data = request()->validate(['name' => 'required']);

        $response = HttpService()->updateDataWithBody('roles', $id, $data, $headers);
        return success('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return success('roles.index');
    }
}
