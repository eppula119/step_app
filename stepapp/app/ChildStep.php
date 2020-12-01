<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // 認証系インスタンス
use Illuminate\Database\Eloquent\Model;


class ChildStep extends Model
{
    //データを取得時、Carbonクラスのデータに置き換え
    protected $dates = ['created_at'];

    //fillableで紐つけ
    protected $fillable = ['title','content','image','time','step_id','created_at',];
}
