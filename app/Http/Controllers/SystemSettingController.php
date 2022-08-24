<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\SystemSetting;
use App\Http\Requests\SystemSettingUpdateRequest;
use Illuminate\Support\Facades\Cookie;

class SystemSettingController extends Controller
{
    public function edit()
    {
        // $provinces = Province::all();
        $provinces = getData()->getDataFromType('locations/provinces')->data;
        return view('backend.setting.system_setting', compact('provinces'));
    }

    public function update(SystemSettingUpdateRequest $request)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $response = HttpService()->updateDataWithBody('systemSettings',1, $request->validated(),$headers);
        if($response->status == 401)
            return error('login');

        return back()->with('success', 'Operation Successful');
    }
}
