<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Services\ImageServices;
use Illuminate\Support\Facades\Cookie;

class SizeController extends Controller
{
    public function index()
    {
        $data = getData()->getDataWithParam('sizes',request()->all());
        $sizes = $data->sizes;
        return view('backend.size.index', compact('data','sizes'));
    }

    public function create()
    {
        return view('backend.size.create');
    }

    public function store()
    {
        $data = request()->validate(['name' => 'required']);
        Size::create($data);
        return success('sizes.index');
    }

    public function edit($id)
    {
        $size = getData()->getDataFromId('sizes',$id)->sizes;
        return view('backend.size.edit', compact('size'));
    }

    public function update($id)
    {
        $data = request()->validate(['name' => 'required']);
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->updateDataWithBody('sizes', $id, $data, $headers);
        if(isset($payload->status) && $payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('sizes.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->deletedData('sizes', $id, [], $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('sizes.index');
    }
}
