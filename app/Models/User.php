<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'created_by',
        'last_login_at',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    // define attributes : Start
    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', config('constant.roles.admin'))->exists();
    }

    public function getIsStaffAttribute()
    {
        return $this->roles()->where('id', config('constant.roles.staff'))->exists();
    }

    public function getIsCustomerAttribute()
    {
        return $this->roles()->where('id', config('constant.roles.customer'))->exists();
    }
    // define attributes : End

    // user profile image : Start
    public function profileImage()
    {
        return $this->morphOne(Upload::class, 'uploadsable')->where('type', 'user_profile');
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profileImage) {
            return $this->profileImage->file_url;
        }
        return "";
    }

    public function uploads()
    {
        return $this->morphMany(Upload  ::class, 'uploadsable');
    }
    // user profile image : End


    public function posts()
    {
        return $this->hasMany(Post::class,'user_id');
    }
}
