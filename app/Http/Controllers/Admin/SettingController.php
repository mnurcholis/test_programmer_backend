<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $page_title                 = 'Settings Website';
        $setting                    = Settings::find(1);
        $data['id']                 = 1;

        return view('admin.setting.index', compact(['setting', 'page_title']))->with($data);
    }

    public function save(Request $request)
    {
        $path                   = 'assets/img';

        if ($request->file('logo_image') != null || $request->file('logo_image') != '') {
            $new_logo = "logo-" . time() . "." . $request->file('logo_image')->getClientOriginalExtension();
            $request->file('logo_image')->move($path, $new_logo);
            if (Settings::find(1)->logo != 'logo.png') {
                File::delete($path . '/' . Settings::find(1)->logo);
            }

            $data['logo'] = $new_logo;
        }

        if ($request->file('favicon_image') != null || $request->file('favicon_image') != '') {
            $new_favicon = "favicon-" . time() . "." . $request->file('favicon_image')->getClientOriginalExtension();
            $request->file('favicon_image')->move($path, $new_favicon);
            if (Settings::find(1)->favicon != 'favicon') {
                File::delete($path . '/' . Settings::find(1)->favicon);
            }
            $data['favicon'] = $new_favicon;
        }

        $data['app_name']       = $request->app_name;
        $data['description']    = $request->description;

        Settings::where('id', '=', '1')->update($data);

        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Update Data"
        ]);
    }
}
