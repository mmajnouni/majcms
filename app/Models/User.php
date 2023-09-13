<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getAvatarAttribute($value) {
        return asset($value);
    }

    public  function posts() {
        return $this->hasMany(Post::class);
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }
    public function Roles() {
        return $this->belongsToMany(Role::class);
    }

    public function userHasRoles($role_name) {
        foreach($this->Roles as $role) {
             if(Str::lower($role_name) == Str::lower($role->name)) {
                 return true;
             }
             return false;
        }
    }
}
