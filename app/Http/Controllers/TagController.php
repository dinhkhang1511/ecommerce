<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TagController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('tags', request()->all());
        $tags = $data->tags;

        return view('backend.tag.index', compact('tags','data'));
    }

    public function create()
    {
        return view('backend.tag.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->postDataWithBody('tags', $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('tags.index');
    }

    public function edit($id)
    {
        $tag = GetData()->getDataFromId('tags', $id)->tags;

        return view('backend.tag.edit', compact('tag'));
    }

    public function update($id)
    {
        $data = request()->all();
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $payload = HttpService()->updateDataWithBody('tags', $id, $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('tags.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $tag = HttpService()->deletedData('tags', $id, [], $headers);

        return success('tags.index');
    }
}
