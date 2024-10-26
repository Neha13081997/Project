<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Register\StoreRequest;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        return view('auth.register',compact(('roles')));
    }

    public function registerUser(StoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'created_by' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'status' => 1,
        ]);
        $role = Role::where('id', $request->role)->first();
        if ($role) {
            User::findOrFail($user->id)->roles()->sync($role->id);
        }
        return redirect()->route('dashboard.index');
    }
}
