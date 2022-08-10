<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Services\ImageServices;
use Illuminate\Support\Facades\Cookie;

class ColorController extends Controller
{
    public function index()
    {
        $data = getData()->getDataWithParam('colors',request()->all());
        $colors = $data->colors;
        return view('backend.color.index', compact('data','colors'));
    }

    public function create()
    {
        return view('backend.color.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required', 'code' => 'required']);
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->postDataWithBody('colors', $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('colors.index');
    }

    public function edit($id)
    {
        $color = getData()->getDataFromId('colors',$id)->colors;
        return view('backend.color.edit', compact('color'));
    }

    public function update($id)
    {
        $data = request()->validate(['name' => 'required', 'code' => 'required']);
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->updateDataWithBody('colors', $id, $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('colors.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $response =  HttpService()->deletedData('colors', $id, [], $headers);
        return success('colors.index');
    }
}
