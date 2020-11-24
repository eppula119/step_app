<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //認証に関わる物を使う
use App\Step;
use App\Category;
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

    public function registerStep(Request $request)
    {
        Log::debug('バリデーション開始');
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:10000',
            'image' => 'file|max:1000',
            'category_id' => 'required|integer',
            'time' => 'required|integer'
        ]);
        Log::debug('バリデーションok');

        $step = new Step();
        $user_id = Auth::id();
        $file_name = "";

        // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
        $file_name = time() . '.' . $request['image']->getClientOriginalName();
        $request['image']->storeAs('public', $file_name);
        // プロジェクト内にファイルを保存
        $step['image'] = '/storage/' . $file_name;


        $step->title = $request->title;
        $step->content = $request->content;
        $step->category_id = $request->category_id;
        $step->time = $request->time;
        $step->user_id = $user_id;
        $step->save();
        Log::debug(print_r($step, true));

       
 

    }
}
