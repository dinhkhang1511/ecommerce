<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\SystemSetting;
use App\Http\Requests\SystemSettingUpdateRequest;

class SystemSettingController extends Controller
{
    public function edit()
    {
        $provinces = Province::all();
        return view('backend.setting.system_setting', compact('provinces'));
    }

    public function update(SystemSettingUpdateRequest $request)
    {
        $setting = SystemSetting::all()->first();
        if (request()->has('logo')) {
            delete_file($setting->logo);
        }
        
        if (request()->has('favicon')) {
            delete_file($setting->favicon);
        }

        $setting->update($request->validated());
        return back();
    }
}
