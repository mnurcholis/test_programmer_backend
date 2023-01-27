<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $page_title                 = 'DashBoard';
        $setting                    = Settings::find(1);
        $data['id']                 = 1;

        return view('admin.dashboard', compact(['setting', 'page_title']))->with($data);
    }
}
