<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
    // public function __construct($token)
    // {
    //     $this->token = $token; // 引数でトークンを受け取る
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     $from = config('mail.from.address');
    // return $this
    //       ->from($from) // 送信元
    //       ->subject('リセットパスワードメール') // メールタイトル
    //       ->view('mail.reset_password_mail')
    //       ->with(['url' => $this->token]);
    // }
    public function build()
    {
        // 件名
        $subject = 'パスワードリセットメール';

        // コールバックURLをルート名で取得
        $baseUrl = config('app.url'); // .envの「APP_URL」に設定したurlを取得
        $token = $this->token;
        $url = "{$baseUrl}/reset-password/{$token}";

        // 送信元のアドレス
        // .envの「MAIL_FROM_ADDRESS」に設定したアドレスを取得
        $from = config('mail.from.address');

        return $this->from($from)
            ->subject($subject)
            // 送信メールのビュー
            ->view('mail.reset_password_mail')
            // ビューで使う変数を渡す
            ->with('url', $url);
    }
}
