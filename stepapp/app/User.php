<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Step;
use App\Favorite;
use App\Challenge;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function step_users()
    // {
    //     return $this->hasMany('App\step_user', 'user_id');
    // }
    public function steps()
    {
        return $this->hasMany('App\Step');
    }

    // userに結びつくstepを複数取得(登録したSTEP取得時に必要)
    public function step_users()
    {
        return $this->hasMany('App\Step', 'user_id');
    }

    // userに結びつくstepを複数取得(お気に入りSTEP取得時に必要)
    public function favorites()
    {
        return $this->belongsToMany('App\Step', 'favorites')->withTimestamps();
    }

    // userに結びつくstepを複数取得(チャレンジ中STEP取得時に必要)
    public function challenges()
    {
      return $this->belongsToMany('App\Step', 'challenges')->withTimestamps();
    }
    
}
