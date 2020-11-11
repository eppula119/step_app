<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //認証に関わる物を使う
use Illuminate\Support\Facades\Log; //ログを取る

class StepController extends Controller
{
    public function __construct()
    {
      // 認証が必要
      $this->middleware('auth');
    }
    // ログイン中のユーザー情報を取得
    public function isLogin()
    {Log::debug('バリデーション開始');
        return Auth::user();
    }
}
