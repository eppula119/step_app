<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //認証に関わる物を使う
use App\Step;
use App\ChildStep;
use App\Category;
use Illuminate\Support\Facades\Log; //ログを取る

class StepController extends Controller
{
    public function __construct()
    {
      // 認証が必要
      $this->middleware('auth')->except(['index']);
    }
    // ログイン中のユーザー情報を取得
    public function isLogin()
    {Log::debug('バリデーション開始');
        return Auth::user();
    }
    public function showStepList() // STEP一覧画面表示
    {
        Log::debug('STEP一覧取得開始');
        // $steps = Step::with(['category', 'favorites'])->withCount('reviews')->orderBy('created_at', 'desc')->get(); // 新しい順にSTEP全て取得      
        // return $steps;
        
        $steps = Step::with(['user', 'category'])->orderBy('created_at', 'desc')->get();
        // $steps = Step::get();
        Log::debug(print_r($steps, true));
        return $steps;
    }

    public function showStepDetail() // STEP詳細画面表示
    {
        Log::debug('STEP詳細取得開始');
    }

    public function indexCategory() // 各カテゴリー取得
    {
        $allCategory = Category::get(); //　全カテゴリーデータ取得

        $categorys = array('category' => $allCategory);
        return $categorys;
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
        Log::debug(print_r($request['image'] , true));

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
        Log::debug(print_r($step->id, true));
        return ["step_id" => $step->id];
       
 

    }

    public function registerChild(Request $request)
    {
        Log::debug('子STEP登録バリデーション開始');
        // バリデーション
        $request->validate([
            'step_id' => 'required|integer',
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:10000',
            'image' => 'file|max:1000',
            'time' => 'required|integer'
        ]);
        Log::debug('バリデーションok');

        $step = new ChildStep();
        $user_id = Auth::id();
        $file_name = "";

        // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
        $file_name = time() . '.' . $request['image']->getClientOriginalName();
        $request['image']->storeAs('public', $file_name);
        // プロジェクト内にファイルを保存
        $step['image'] = '/storage/' . $file_name;


        $step->title = $request->title;
        $step->content = $request->content;
        $step->step_id = $request->step_id;
        $step->time = $request->time;
        $step->save();
        


    }
}
