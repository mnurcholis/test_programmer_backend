<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\DemoMail;
use App\Models\Password_resets;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register()
    {
        $page_title                 = 'Register';
        $setting                    = Settings::find(1);

        return view('auth.pages.registers', compact(['setting', 'page_title']));
    }

    public function register_action(Request $request)
    {
        $setting = Settings::find(1);
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        $token = Str::random(100);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        $create_activate = new Password_resets([
            'email'         => $request->email,
            'token'         => $token
        ]);
        $create_activate->save();

        $mailData = [
            'subject' => 'account activation' . $setting->app_name,
            'title' => 'Mail from ' . $setting->app_name,
            'body' => 'Click <a href="' . url('/') . '/activate?email=' . $request->email . '&token=' . $token . '">here</a> to activate account'
        ];
        Mail::to($request->email)->send(new DemoMail($mailData));

        return redirect()->route('login')->with('success', 'Registration success. Please check your email for activation!');
    }

    public function forgot_send(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $check_email = User::where(['email' => $request->email]);

        if ($check_email->count() > 0) {
            $token = Str::random(100);

            $create_activate = new Password_resets([
                'email'         => $request->email,
                'token'         => $token
            ]);
            $create_activate->save();

            $mailData = [
                'subject' => 'Reset Password',
                'title' => 'Mail from UYA UYA',
                'body' => 'Click <a href="' . url('/') . '/reset_password?email=' . $request->email . '&token=' . $token . '">here</a> to reset your password.'
            ];
            Mail::to($request->email)->send(new DemoMail($mailData));

            return redirect()->route('login')->with('success', 'Reset Password success. Please check your email for reset password!');
        } else {
            return back()->withErrors([
                'password' => 'Email-Address Not Found..',
            ]);
        }
    }

    public function activate(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $check_email = User::where(['email' => $email]);
        if ($check_email->count() > 0) {
            $check_token = Password_resets::where(['token' => $token]);
            if ($check_token->count() > 0) {
                $data_token = $check_token->firstOrFail();
                $created = new Carbon($data_token->created_at);
                $now = Carbon::now();
                $difference = ($created->diff($now)->days < 1);

                if ($difference == 'today') {
                    $data = [
                        'email'                 => $request->email,
                        'email_verified_at'     => date("Y-m-d H:i:s")
                    ];
                    User::where('email', $request->email)->update($data);
                    $password_resets   = Password_resets::where(['email' => $request->email]);
                    $password_resets->delete();
                } else {
                    $password_resets   = Password_resets::where(['email' => $email]);
                    $password_resets->delete();
                    return redirect()->route('login')->with('success', 'Token is more than 24 hours ');
                }
            } else {
                return redirect()->route('login')->with('success', 'Token is Wrong!!');
            }
        } else {
            return redirect()->route('login')->with('success', 'Email account not Found!, please Create Account.');
        }
    }

    public function forgot_the_password()
    {
        $page_title                 = 'Forgot Password Acount';
        $setting                    = Settings::find(1);

        return view('auth.pages.forgot_password', compact(['setting', 'page_title']));
    }

    public function reset_password(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $check_email = User::where(['email' => $email]);
        if ($check_email->count() > 0) {
            $check_token = Password_resets::where(['token' => $token]);
            if ($check_token->count() > 0) {
                $data_token = $check_token->firstOrFail();
                $created = new Carbon($data_token->created_at);
                $now = Carbon::now();
                $difference = ($created->diff($now)->days < 1);

                if ($difference == 'today') {
                    $page_title                 = 'Reset Password Acount';
                    $setting                    = Settings::find(1);

                    return view('auth.pages.reset_password', compact(['setting', 'page_title', 'email', 'token']));
                } else {
                    $password_resets   = Password_resets::where(['email' => $email]);
                    $password_resets->delete();
                    return redirect()->route('login')->with('success', 'Token is more than 24 hours ');
                }
            } else {
                return redirect()->route('login')->with('success', 'Token is Wrong!!');
            }
        } else {
            return redirect()->route('login')->with('success', 'Email account not Found!, please Create Account.');
        }
    }

    public function reset_password_action(Request $request)
    {
        $request->validate([
            'email'             => 'required',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password'
        ]);

        $data = [
            'password' => Hash::make($request->password),
        ];
        User::where('email', $request->email)->update($data);

        $password_resets = Password_resets::where(['email' => $request->email]);
        $password_resets->delete();

        return redirect()->route('login')->with('success', 'Reset success. Please login!');
    }
}
