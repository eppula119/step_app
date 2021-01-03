<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth; //認証に関わる物を使う
use App\Rules\AlphaNumHalf;
use App\Rules\MegaBytes;
use App\Step;
use App\User;
use App\Favorite;
use App\ChildStep;
use App\Category;
use Illuminate\Support\Facades\Log; //ログを取る

class StepController extends Controller
{
    public function __construct()
    {
      // 認証が必要
      $this->middleware('auth')->except(['showStepList', 'showStepDetail']);
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
        
        $steps = Step::with(['user', 'category', 'favorites'])->orderBy('created_at', 'desc')->get();
        // $steps = Step::get();
        Log::debug(print_r($steps, true));
        return $steps;
    }

    public function showStepDetail($id) // STEP詳細画面表示
    {
        Log::debug('STEP詳細取得開始');
        $step = Step::where('id', $id)->with(['category', 'favorites'])->first();
        Log::debug(print_r($step, true));
        Log::debug('取得したSTEP１つの中身↑');
        $child = ChildStep::where('step_id', $id)->orderBy('created_at', 'asc')->get();

        $step_child = [ "step"=> $step, "child" => $child ];
        Log::debug($step_child);

        return $step_child ?? abort(404);
       
    }

    public function showChild($id) // 子STEP詳細画面表示
    {
        Log::debug('子STEP詳細取得開始');
        $child = ChildStep::where('step_id', $id)->with(['step'])->orderBy('created_at', 'asc')->get();
        Log::debug("ChildStep::where(step_id')のなかみ");
        Log::debug($child);

        return ["child" => $child] ?? abort(404);
       
    }

    public function showMypage() // マイページ画面表示
    {
        // ---------------------------------------投稿したSTEP
        $myStep = [];
        $myData = Auth::user()->step_users()->get(); // ログインユーザーの投稿済みSTEP取得
        Log::debug("myData(Auth::user()->step_users()->get())の中身");
        Log::debug(print_r($myData, true));

        foreach($myData as $step)
        {
            Log::debug("foreach中の単体stepの中身");
            Log::debug(print_r($step, true));
            $myStep[] = $step->id; // 投稿済みSTEPデータのidのみ取得
        }

        Log::debug("foreach直後のドルmyStep[]の中身");
        Log::debug(print_r($myStep, true));

        // STEPのidに基づくSTEP情報とカテゴリー情報を最新順に取得
        $myData = Step::whereIn('id', $myStep)->with(['user', 'category'])->orderBy('created_at', 'desc')->get();

        Log::debug("最終的なドルmyDataの中身");
        Log::debug(print_r($myData, true));

        // ---------------------------------------お気に入りSTEP
        $favStep = [];
        $favData = [];
        $user = Auth::user();

        foreach($user->favorites as $step)
        {
             $favStep[] = $step->id;  // お気に入りSTEPのidのみ取得
        }
         // STEPのidに基づくSTEP情報とカテゴリー情報を最新順に取得
        $favData = Step::whereIn('id', $favStep)->with('user', 'category')->orderBy('created_at', 'desc')->get();
        Log::debug(print_r($favData, true));

        // ---------------------------------------チャレンジ中STEP
        $challengeStep = [];
        $challengeData = [];

        foreach($user->challenges as $step)
        {
             $challengeStep[] = $step->id;  // チャレンジ中STEPのidのみ取得
        }
        
        
        // STEPのidに基づくSTEP情報とカテゴリー情報を最新順に取得
        $challengeData = Step::whereIn('id', $challengeStep)->with('user','category','child_steps', 'child_steps.cleared')->orderBy('created_at', 'desc')->get();
        Log::debug("ドルchallengeDataの中身");
        Log::debug(print_r($challengeData, true));

        //

        
        return ["myStep" => $myData, "favStep" => $favData, "challengeStep" => $challengeData] ;
    }

    // チャンレンジ登録
    public function challenge(string $id)
    {
        $step = Step::where('id', $id)->with('challenges')->first();
        
        Log::debug("[with(challenges)リレーション後の中身]");
        Log::debug(print_r($step, true));

        if(!$step) {
            abort(404);
        }
        
        Log::debug("step->challenges()後の中身");
        Log::debug(print_r($step->challenges, true));

        $step->challenges()->detach(Auth::user()->id);
        $step->challenges()->attach(Auth::user()->id);

        $child = ChildStep::where('step_id', $id)->orderBy('created_at', 'asc')->first();
        Log::debug("Child::where('step_id', ドルid)->orderBy('created_at', 'asc')->get()の中身]");
        Log::debug(print_r($child, true));

        return ["step_id" => $id, "child_id" => $child["id"]] ;
    }

    // クリア登録
    public function clear(string $id)
    {
        Log::debug("clear通信開始");
        Log::debug(print_r($id, true));
        $child = ChildStep::where('id', $id)->with('clears')->first();
        
        Log::debug("[with(clears)リレーション後の中身]");
        Log::debug(print_r($child, true));

        if(!$child) {
            abort(404);
        }
        
        Log::debug("child->clears後の中身");
        Log::debug(print_r($child->clears, true));
        Log::debug("child->clears終了");

        $child->clears()->detach(Auth::user()->id);
        $child->clears()->attach(Auth::user()->id);

        return ["step_id" => $id];
    }

    // お気に入り登録
    public function favorite(string $id)
    {
        $step = Step::where('id', $id)->with('favorites')->first();
        
        Log::debug("[with(favorites)リレーション後の中身]");
        Log::debug(print_r($step, true));

        if(!$step) {
            abort(404);
        }
        
        Log::debug("step->favorite()後の中身");
        Log::debug(print_r($step->favorites, true));

        $step->favorites()->detach(Auth::user()->id);
        $step->favorites()->attach(Auth::user()->id);

        return ["step_id" => $id] ;
    }

    // お気に入り解除
    public function unfavorite($id)
    {
        $step = Step::where('id', $id)->with('favorites')->first();
        
        if(!$step) {
            abort(404);
        }
        Log::debug(print_r($step, true));

        $step->favorites()->detach(Auth::user()->id);


        return ["step_id" => $id];
    
    }



    public function indexCategory() // 各カテゴリー取得
    {
        $allCategory = Category::get(); //　全カテゴリーデータ取得

        $categorys = array('category' => $allCategory);
        return $categorys;
    }

    public function registerStep(Request $request)
    {
        Log::debug('バリデーション開始2');
        
        Log::debug('リクエスト画像');
        Log::debug(print_r($request['image'] , true));
        
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:5000',
            'category' => 'required|integer',
            'time' => 'required|integer'
        ]);
        if(!empty($request['image'])) {
            Log::debug('バリデーション2次審査中！');
            $rules = ['image' => ['file', new MegaBytes(1)]];
            $this->validate($request, $rules);
        }
         Log::debug('バリデーションok');


        $step = new Step();
        $user_id = Auth::id();
        $file_name = "";

        if(!empty($request['image'])) {
        // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
        $file_name = time() . '.' . $request['image']->getClientOriginalName();
        $request['image']->storeAs('public', $file_name);
        // プロジェクト内にファイルを保存
        $step['image'] = '/storage/' . $file_name;
        Log::debug('画像登録ok');
        }

        $step->title = $request->title;
        $step->content = $request->content;
        $step->category_id = $request->category;
        $step->time = $request->time;
        $step->user_id = $user_id;
        $step->save();
        return response()->json(['step_id' => $step->id, 'state' => 'NY'], 201);
        
        Log::debug("新規でバック終わり");

        
    }

    public function registerChild(Request $request)
    {
        Log::debug('子STEP登録バリデーション開始');
        // バリデーション
        $request->validate([
            'step_id' => 'required|integer',
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:5000',
            'time' => 'required|integer',
        ]);
         if(!empty($request['image'])) {
            Log::debug('バリデーション2次審査中！');
            $rules = ['image' => ['file', new MegaBytes(1)]];
            $this->validate($request, $rules);
        }
         Log::debug('バリデーションok');

        $step = new ChildStep();
        $user_id = Auth::id();
        $file_name = "";

        if(!empty($request['image'])) {
        // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
        $file_name = time() . '.' . $request['image']->getClientOriginalName();
        $request['image']->storeAs('public', $file_name);
        // プロジェクト内にファイルを保存
        $step['image'] = '/storage/' . $file_name;
        }

        $step->title = $request->title;
        $step->content = $request->content;
        $step->step_id = $request->step_id;
        $step->time = $request->time;
        $step->save();
    }

    public function updateStep(Request $request, $id)
    {   
        $step = Step::find($id);
        Log::debug('STEP画像');
        Log::debug(print_r($step['image'] , true));
        Log::debug('リクエスト画像');
        Log::debug(print_r($request['image'] , true));

        Log::debug('編集バリデーション開始');
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:5000',
            'category' => 'required|integer',
            'time' => 'required|integer'
        ]);
        Log::debug('バリデーション1次審査クリア！');
        if(!empty($request['image'])) {
            Log::debug('バリデーション2次審査中！');
            $rules = ['image' => ['file', new MegaBytes(1)]];
            $this->validate($request, $rules);
        }
        Log::debug('編集バリデーションok');
        
        $step = Step::find($id);
        $user_id = Auth::id();
        

        if(!empty($request['image'])){ // 画像が編集されている場合、新しく登録
            Log::debug('画像が編集されているため新しいファイル名作成！');
            $file_name = "";
            // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
            $file_name = time() . '.' . $request['image']->getClientOriginalName();
            $request['image']->storeAs('public', $file_name);
            // プロジェクト内にファイルを保存
            $step['image'] = '/storage/' . $file_name;
        }
        
        $step->title = $request->title;
        $step->content = $request->content;
        $step->category_id = $request->category;
        $step->time = $request->time;
        $step->user_id = $user_id;
        $step->save();
        return response()->json(['step_id' => $step->id, 'state' => 'NY'], 200);
        
        Log::debug("編集でバック終わり");

        Log::debug(print_r($step->id, true));
        Log::debug('編集メソッド終了');
        
    }

    public function updateChild(Request $request, $id)
    {
        $step = ChildStep::find($id);
        Log::debug('子STEP登録バリデーション開始');
        // バリデーション
        $request->validate([
            'step_id' => 'required|integer',
            'title' => 'required|string|max:30',
            'content' => 'required|string|max:5000',
            'time' => 'required|integer',
        ]);
        Log::debug('子STEPバリデーション1次審査クリア！');
        if(!empty($request['image'])) {
            Log::debug('子STEPバリデーション2次審査中！');
            $rules = ['image' => ['file', new MegaBytes(1)]];
            $this->validate($request, $rules);
        }
        Log::debug('子STEP編集バリデーションok');
        $step = ChildStep::find($id);
        $user_id = Auth::id();

        if(!empty($request['image'])){ // 画像が編集されている場合、新しく登録
        $file_name = "";
        // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
        $file_name = time() . '.' . $request['image']->getClientOriginalName();
        $request['image']->storeAs('public', $file_name);
        // プロジェクト内にファイルを保存
        $step['image'] = '/storage/' . $file_name;

        }
        
        $step->title = $request->title;
        $step->content = $request->content;
        $step->step_id = $request->step_id;
        $step->time = $request->time;
        $step->save();
        Log::debug("編集でバック終わり");
        Log::debug(print_r($step->id, true));
        Log::debug('編集メソッド終了');
        return response()->json(['step_id' => $step->id, 'state' => 'NY'], 200);
        
    }
    
       public function updateProfile(Request $request) // プロフィール登録・編集
    {
        $user = Auth::user();
        Log::debug('STEP画像');
        Log::debug(print_r($request['image'] , true));
        Log::debug('リクエスト画像');
        Log::debug(print_r($request['profile'] , true));

        Log::debug('編集バリデーション開始');
        // バリデーション
        $request->validate([
            'profile' => 'string|max:300',
        ]);
        Log::debug('バリデーション1次審査クリア！');
        if(!empty($request['image'])) {
            Log::debug('バリデーション2次審査中！');
            $rules = ['image' => ['file', new MegaBytes(1)]];
            $this->validate($request, $rules);
        }
        Log::debug('編集バリデーションok');

        Log::debug('バリデーション1次審査クリア！');
        if($request['email'] !== $user->email) {
            Log::debug('バリデーション3次審査中！');
            $request->validate([
            'email' => 'email|unique:users',
            ]);
        }
        Log::debug('emailバリデーションok');
        
        
        

        if(!empty($request['image'])){ // 画像が編集されている場合、新しく登録
            Log::debug('画像が編集されているため新しいファイル名作成！');
            $file_name = "";
            // ファイルの名前をタイムスタンプに付与し、ファイル名を作成。
            $file_name = time() . '.' . $request['image']->getClientOriginalName();
            $request['image']->storeAs('public', $file_name);
            // プロジェクト内にファイルを保存
            $user['image'] = '/storage/' . $file_name;
        }
        
        $user->profile = $request->profile;
        $user->email = $request->email;
        
        $user->save();
        return response()->json(["user_id" => $user->id, "state" => "NY"], 200);
        
        Log::debug("編集でバック終わり");

        Log::debug(print_r($user->id, true));
        Log::debug('編集メソッド終了');
    }


}
