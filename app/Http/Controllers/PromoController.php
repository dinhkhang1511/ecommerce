<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('promos', request()->all());
        $promos = $data->promos;
        return view('backend.promo.index', compact('promos', 'data'));
    }

    public function create()
    {
        return view('backend.promo.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $payload =  HttpService()->postDataWithBody('promos', $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('promos.index');
    }

    public function edit($id)
    {
        $promo = GetData()->getDataFromId('promos', $id)->promos;

        return view('backend.promo.edit', compact('promo'));
    }

    public function update($id)
    {
        $data = request()->all();
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $payload = HttpService()->updateDataWithBody('promos', $id, $data, $headers);
        if($payload->status == 402)
            return back()->with('errors', $payload->errors);

        return success('promos.index');
    }

    public function destroy($id)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];

        $promo = HttpService()->deletedData('promos', $id, [], $headers);
        return success('promos.index');
    }
}
