<?php

namespace App;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // 認証系インスタンス
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    //データを取得時、Carbonクラスのデータに置き換え
    // protected $dates = ['created_at'];

    // jsonに含めるアクセサ
    protected $appends = [
      'favorited_by_user',
    ];

    //fillableで紐つけ
    protected $fillable = ['title','content','image','category_id','time','user_id','created_at',];

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

    // stepに結びつくuserを複数取得
    //    public function favorites()
    //    {
    //        return $this->belongsToMany('Favorite');
    //    }
    // public function favorites()
    // {
    //     return $this->belongsToMany('App\User', 'favorites')->withTimestamps();
    // }

    // stepに結びつくuserを複数取得
    // public function step_users()
    // {
    //     return $this->belongsToMany('App\User', 'step_user')->withTimestamps();
    // }

    // 
    public function getFavoritedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

    //     return $this->favorites->contains(Auth::user());
    }


}
