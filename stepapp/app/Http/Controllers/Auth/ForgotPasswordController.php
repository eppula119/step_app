<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; 
use App\Models\ResetPassword;
use App\Mail\ResetPasswordMail; 
use Illuminate\Support\Facades\Log; //ログを取る

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * send mail
     * 送られてきた内容をテーブルに保存してパスワード変更メールを送信
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return ResetPassword
     */
    public function forgot(Request $request)
    {
        // validation
        // 送られてきた内容のバリデーション
        $this->validator($request->all())->validate();

        // create token
        // トークンを作成
        $token = $this->createToken();

        // delete old data
        // 古いデータが有れば削除
        ResetPassword::destroy($request->email);

        // insert
        // 送られてきた内容をテーブルに保存
        $resetPassword = new ResetPassword($request->all());
        $resetPassword->token = $token;
        $resetPassword->save();

        $this->sendResetPasswordMail($request->all(), $token);
        return $resetPassword;
    }

    /**
     * Get a validator
     * バリデーション
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
        ]);
    }

    /**
     * create token
     * トークンを作成する
     * @return stirng
     */
    private function createToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    /**
     * send reset password mail
     * メールクラスでメールを送信
     * 
     * @param string $email
     * @param string $token
     * @return void
     */

    public function sendResetPasswordMail($request, $token)
    {
        // メール送信
        Mail::to($request['email'])->send(new ResetPasswordMail($token));
    }
}
