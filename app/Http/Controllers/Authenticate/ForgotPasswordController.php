<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\ActiveUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate(['email' => ['required','email','regex:/^(?!.*[\/]).+@(?!.*[\/]).+\.(?!.*[\/]).+$/i','exists:users,email,deleted_at,NULL',new ActiveUser]], getCommonValidationRuleMsgs());
        DB::beginTransaction();
        try{
            $user = User::where('email',$request->email)->first();
            if($user){
                $token = generateRandomString(64);
                $email_id = $request->email;
                $reset_password_url = route('resetPassword',['token'=>$token]);
                
                DB::table('password_reset_tokens')
                ->where('email', $email_id)
                ->delete();
               
                DB::table('password_reset_tokens')->insert([
                    'email' => $email_id,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
               
                $subject = 'Reset Password Notification';
                Mail::to($email_id)->send(new ResetPasswordMail($user->name,$reset_password_url,$subject));

                DB::commit();

                return redirect()->back()->with('status',trans('passwords.sent'));

            }else{
                // Set Flash Message
                return redirect()->back()->withErrors(['email' => trans('messages.invalid_email')])->withInput($request->only('email'));

            }

        }catch(\Exception $e){
            DB::rollBack();
            // dd($e->getMessage().'->'.$e->getLine());
            return redirect()->back()->with('error',trans('messages.error_message'));
        }
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('auth.passwords.reset')->with(['token' =>$request->token]);
    }

    public function resetPassword(Request $request)
    {

        $validated = $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',

        ], getCommonValidationRuleMsgs());

        DB::beginTransaction();
        try{
            $updatePassword = DB::table('password_reset_tokens')->where(['token' => $request->token])->first();
            if(!$updatePassword){
                return redirect()->back()->with('error', trans('passwords.token'))->withInput($request->all());
            }else{
                $email_id = $updatePassword->email;
                $retriveUser = User::where('email',$email_id)->first();
                if($retriveUser->status == 1){
                    $user = User::where('email', $email_id)
                    ->update(['password' => Hash::make($request->password)]);

                    DB::table('password_reset_tokens')->where(['email'=> $email_id])->delete();

                    $routeName = 'login';

                    DB::commit();
                    return redirect()->route($routeName)->with('status',trans('passwords.reset'));

                }else{
                    return redirect()->back()->withErrors(['error' => trans('passwords.suspened')])->withInput($request->all());
                }

            }
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage().'->'.$e->getLine());
            return redirect()->back()->with('error',trans('messages.error_message'));
        }
    }
}
