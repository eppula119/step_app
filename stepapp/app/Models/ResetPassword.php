<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'password_resets'; // テーブル名を指定
    protected $primaryKey = 'email'; // プライマリキーを「email」に変更(デフォルトは「id」)
    protected $keyType = 'string'; // プライマリキーのタイプを指定
    public $incrementing = false; // タイプがストリングの場合はインクリメントを「false」にしないといけない

    protected $fillable = [ // モデルが以下のフィールド以外を持たないようにする
        'email',
        'token',
    ];

    public $timestamps = false; // タイムスタンプは「created_at」のフィールドだけにしたい為、「false」を指定

    public static function boot() // 自前で用意する
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
