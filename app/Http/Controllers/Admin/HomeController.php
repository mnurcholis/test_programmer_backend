<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use App\Models\Retribusi;
use App\Models\Settings;
use App\Models\SiteOperator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $page_title                 = 'DashBoard';
        $setting                    = Settings::find(1);
        $data['total_operator']     = Operator::get()->count();
        $data['total_site']         = SiteOperator::get()->count();
        $data['total_retribusi']    = Retribusi::get()->count();
        $data['id']                 = 1;

        return view('admin.dashboard', compact(['setting', 'page_title']))->with($data);
    }
}
