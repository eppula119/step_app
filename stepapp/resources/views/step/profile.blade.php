
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>プロフィール</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <script src="https://kit.fontawesome.com/39ab84bfc8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:400,700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
</head>

<body>
<div id="app">
   <header class="l-header"> 

    <div class="p-header">
        <div class="p-header__logo">
          <a href class="p-topLink">
            <img src="./images/logo.png" alt class="p-topLink__img" />
          </a>
        </div>
        <div class="p-header__search">
          <form action="" class="p-search">
            @csrf
            <input type="text" class="p-search__form">
            <button  type="submit" class="p-search__btn">検索</button>
          </form>
        </div>
        <div class="p-header__menu">
          <button class="p-menuBtn">メニュー</button>
          <div class="p-headerMenu">
            <ul class="p-headerMenu__list">        
              <li class="p-menuItem">マイページ</li>
              <li class="p-menuItem">トップページ</li>
              <li class="p-menuItem">ユーザー登録</li>
              <li class="p-menuItem">
                <form action method="POST">
                  @csrf
                  <button type="submit" class="p-logout c-btn">ログアウト</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      <div class="p-headerMenuTrigger js-toggle-sp-menu">
          <span class="p-headerMenuTrigger__border"></span>
          <span class="p-headerMenuTrigger__border"></span>
          <span class="p-headerMenuTrigger__border"></span>
      </div>
    </div>

  </header>

  <main class="l-main">
<!--ーーーーーーーーーーーーーーーーーー プロフィール画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-stepForm"> 
      <p class="p-stepForm__title">プロフィール</p>
      <form class="p-registerProfile">
      @csrf
        <div class="p-fileContainer">
          <label class="p-fileContainer__airDrop"><i class="fas fa-user p-userIcon"></i>ドラッグ＆ドロップ
            <input type="file" class="p-dropImg" name="image"/>
            <output class="p-outputImg">
              <img class="p-outputImg__img"/>
            </output>
          </label>
          <span class="c-invalid p-fileContainer__msg" role="alert">
            <strong>画像の容量は10MB以内に抑えてください。</strong>
          </span>
        </div>

　　　　　<p class="p-registerProfile__heading">自己紹介</p>
         <textarea
          class="p-registerProfile__content" name="content"　cols="30"　rows="10" placeholder="内容"
        ></textarea>
        <span class="c-invalid p-contentMsg" role="alert">
          <strong>1000文字以内</strong>
        </span>

        

        <span class="p-registerProfile__heading">メールアドレス</span>
        <input type="email" name="email" class="c-form__input is-invalid p-editEmail" value="" required autocomplete="email" autofocus placeholder="例：hogehoge@gmail.com">

            <span class="c-invalid p-emailMsg" role="alert">
              <strong>メールアドレスの形式になっていません</strong>
            </span>

        <button type="submit" class="c-btnEntry c-btn">登録</button>
      </form>
    </div>
  </main>


  <div class="l-footer">
      <ul class="l-footerMenu">
        <li class="l-footerMenu__list">特定商取引法</li>
        <li class="l-footerMenu__list">プライバシーポリシー</li>
        <li class="l-footerMenu__list">Step</li>
      </ul>
  </div>
</div>

</body>
</html>