<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ImageServices;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Services\HttpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // $http = new HttpService();
        $data =  GetData()->getDataWithParam('categories', $request->all() );
        return view('backend.category.index', compact('data'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $body['name'] = $request->name;
        if($request->hasfile('image_path'))
        {
            $image = $request->file('image_path');
            $ext = $image->getClientOriginalExtension();
            $imageBase64 = base64_encode(file_get_contents($image));
            $body['base64_image'] = $imageBase64;
            $body['extension'] = $ext;
        }

        $payload = HttpService()->postDataWithBody("categories", $body , $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('categories.index');

    }

    public function edit($id)
    {
        $category = GetData()->getDataFromId('categories', $id )->categories;
        return view('backend.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $body['name'] = $request->name;
        if($request->hasfile('image_path'))
        {
            $image = $request->file('image_path');
            $ext = $image->getClientOriginalExtension();
            $imageBase64 = base64_encode(file_get_contents($image));
            $body['base64_image'] = $imageBase64;
            $body['extension'] = $ext;
        }

        $payload = HttpService()->updateDataWithBody("categories",  $id, $body , $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('categories.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $data = HttpService()->deletedData("categories",  $id, [] , $headers);
        return back()->with('success', 'Operation Success');
    }
}
