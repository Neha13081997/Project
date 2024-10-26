<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UserHasRole implements ValidationRule
{
    protected $email;
    protected $roles;
    protected $type;
    protected $attribute;


    public function __construct($roles, $email='', $type='email')
    {
        $this->email = $email;
        $this->roles = is_array($roles) ? $roles : [$roles];
        $this->type = $type;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->attribute = $attribute;
        if($this->type == 'uuid'){
            $col = 'users.uuid';
            $val = $value;
        } else {
            $col = 'users.email';
            $val = $this->email;
        }
        // dd($this->roles);
        $role = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where($col, $val)
                ->whereIn('roles.id', $this->roles)
                ->exists();
        // dd($role);        
        if(!$role)
        {
            $fail(trans('messages.required_role'));
        }       
    }
}
