<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Rules\NoMultipleSpacesRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        return view('backend.profile', compact(('user')));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        // dd($user);
        $updateRecords = [
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule],
            'profile_image'  =>['nullable', 'image', 'max:'.config('constant.profile_max_size'), 'mimes:jpeg,png,jpg'],
            'phone' => [
                'nullable',
                'numeric',
                'regex:/^[0-9]{7,15}$/',
                'not_in:-',
                'unique:users,phone,'. $user->id.',id,deleted_at,NULL',
            ],
        ];

        $request->validate($updateRecords,[
            // 'phone.required'=>'The phone number field is required',
            'phone.regex' =>'The phone number length must be 7 to 15 digits.',
            'phone.unique' =>'The phone number already exists.',
            'profile_image.image' =>'Please upload image.',
            'profile_image.mimes' =>'Please upload image with extentions: jpeg,png,jpg.',
            'profile_image.max' =>'The image size must equal or less than '.config('constant.profile_max_size_in_mb'),
        ]);
        
        if($request->ajax()){
            DB::beginTransaction();
            try {
                $user->update($request->all());

                if($request->has('profile_image')){
                    $uploadId = null;
                    $actionType = 'save';
                    if($profileImageRecord = $user->profileImage){
                        $uploadId = $profileImageRecord->id;
                        $actionType = 'update';
                    }
                  
                    uploadImage($user, $request->profile_image, 'user/profile-images',"user_profile", 'original', $actionType, $uploadId);
                  
                }
                DB::commit();

                $user = User::where('id', $user->id)->first();
                $data = [
                    'success' => true,
                    'profile_image' => $user->profile_image_url,
                    'auth_name' => $user->name,
                    'message' => trans('messages.crud.update_record'),
                ];
                return response()->json($data, 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        // dd($user);
        $request->validate([
            'current_password'  => ['required', 'string','min:8',new MatchOldPassword],
            'password'   => ['required', 'string', 'min:8', 'different:current_password'],
            'password_confirmation' => ['required','min:8','same:password'],
        ], getCommonValidationRuleMsgs());
        if($request->ajax()){
            DB::beginTransaction();
            try {
                $user->update(['password'=> Hash::make($request->password)]);
                DB::commit();
                $data = [
                    'success' => true,
                    'message' => trans('passwords.reset'),
                ];
                return response()->json($data, 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
            }
        }
        return response()->json(['success' => false, 'error_type' => 'something_error', 'error' => trans('messages.error_message')], 400 );
    
    }
}
