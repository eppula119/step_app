<?php

namespace App;
use App\Step;
use App\Clear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // 認証系インスタンス
use Illuminate\Database\Eloquent\Model;


class ChildStep extends Model
{
    //データを取得時、Carbonクラスのデータに置き換え
    protected $dates = ['created_at'];

    //fillableで紐つけ
    protected $fillable = ['title','content','image','time','step_id','created_at',];

    public function step()
    {
        return $this->belongsTo('App\Step');
    }

    // 子stepに結びつくuserを複数取得(クリアデータ参照)
    public function clears()
    {
        return $this->belongsToMany('App\User', 'clears', 'child_id')->withTimestamps();
    }

    // クリアしているか
    public function cleared()
    {
        return $this->hasMany('App\Clear', 'child_id');
    }

    
}
