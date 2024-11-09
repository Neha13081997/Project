<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\ActiveUser;
use App\Rules\UserHasRole;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentialsOnly = $request->validate([
            'email'    => ['required','email','regex:/^(?!.*[\/]).+@(?!.*[\/]).+\.(?!.*[\/]).+$/i','exists:users,email,deleted_at,NULL', new UserHasRole([config('constant.roles.admin'),config('constant.roles.staff'),config('constant.roles.customer')], $request->email),new ActiveUser],
            'password' => 'required|min:8',
        ],
        [
            'email.exists' => trans('validation.invalid'),
        ]);
        $user = User::where('email',$request->email)->first();
       
        if($user){
            
            $remember_me = !is_null($request->remember_me) ? true : false;
            if (Auth::attempt($credentialsOnly, $remember_me))
            {  
                $routeName = 'admin.dashboard.index';
                if(auth()->user()->is_customer){
                    $routeName = 'home';
                }
                return redirect()->route($routeName)->with('status',trans('auth.messages.login.success'));
            }

            $loginRouteName = 'admin.login';
            if($user->is_customer){
                $loginRouteName = 'user.login';
            }
            return redirect()->route($loginRouteName)->with('status',trans('auth.failed'));
        }
    }

    public function logout()
    {
        $routeName = 'admin.login';
        if(auth()->user()->is_customer){
            $routeName = 'user.login';
        }
        Auth::guard('web')->logout();
        return redirect()->route($routeName);
    }
}
