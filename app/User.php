<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   public function chats()
    {
        return $this->belongsToMany('App\Chat');
    }
      public function isNew()
    {
        if(Carbon::parse($this->attributes['created_at'])->diffInHours(Carbon::now()) <= 12) {
            return true;
        }else{
            return false;
        }
    }
}
