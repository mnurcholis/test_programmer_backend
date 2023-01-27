<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $page_title                 = 'Login';
        $setting                    = Settings::find(1);

        return view('auth.pages.login', compact(['setting', 'page_title']));
    }

    public function login_action(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $request->email, 'password' => $request->password))) {
            if (auth()->user()->email_verified_at != "") {
                if (auth()->user()->type == 'admin') {
                    return redirect('admin');
                } else {
                    return redirect('user');
                }
            } else {
                return back()->withErrors([
                    'password' => 'Email- Not verify.',
                ]);
            }
        }

        return back()->withErrors([
            'password' => 'Email-Address And Password Are Wrong.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
