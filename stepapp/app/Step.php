<?php

namespace App;
use App\Category;
use App\ChildStep;
use App\Favorite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // 認証系インスタンス
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    //データを取得時、Carbonクラスのデータに置き換え
    // protected $dates = ['created_at'];

    // jsonに含めるアクセサ
    protected $appends = [
      'favorites_count', 'favorited_by_user'
    ];

    //fillableで紐つけ
    protected $fillable = ['title','content','image','category_id','time','user_id','created_at','favorites_count', 'favorited_by_user'];

    //categoriesテーブルと紐付ける   
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    //ideasテーブルと紐付ける   (多対１)
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //usersテーブルと紐付ける   (多対多)
    // public function users()
    // {
    //     return $this->belongsToMany('App\User')->withTimestamps();
    // }

    // stepに結びつくuserを複数取得(お気に入りデータ参照)
    public function favorites()
    {
        return $this->belongsToMany('App\User', 'favorites')->withTimestamps();
    //   return $this->hasMany('App\Favorite');
    }

    // stepに結びつくuserを複数取得(チャンレジデータ参照)
    public function challenges()
    {
        return $this->belongsToMany('App\User', 'challenges')->withTimestamps();
    }

    // stepに結びつくuserを複数取得
    public function step_users()
    {
        return $this->belongsToMany('App\User', 'step_user')->withTimestamps();
    }

     // STEPに結びつく子STEPを複数取得
    public function child_steps()
    {
        return $this->hasMany('App\ChildStep');
    }
    
    public function getFavoritesCountAttribute() // favorites_countアクセサ設定 
    {
        return $this->favorites->count();
    }
   
    public function getFavoritedByUserAttribute() // favorited_by_userアクセサ設定
    {
        if (Auth::guest()) {
            return false;
        }
        return $this->favorites->contains(function ($user) {
        return $user->id === Auth::user()->id;
        });
        // return $this->favorites->contains(Auth::user());
    }

}
