
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>ログイン</title>
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

  <main class="l-form">

    <div class="l-bg p-authForm"> 
      <div class="p-authForm__container">
        <p class="c-formTitle">ユーザー登録</p>
      <form method="post" class="c-form">

          <span class="c-form__heading">メールアドレス</span>
          <input
            type="email"
            name="email"
            class="c-form__input is-invalid"
            value
            required
            autocomplete="email"
            autofocus
            placeholder="例：hogehoge@gmail.com"
          />

          <span class="c-invalid" role="alert">
            <strong>※パスワードが違います</strong>
          </span>

          <span class="c-form__heading">パスワード</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
          />

          <span class="c-invalid" role="alert">
            <strong>※パスワードが違います</strong>
          </span>

          <span class="c-form__heading">パスワード再入力</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
          />
          <span class="c-invalid" role="alert">
            <strong>※パスワードが違います</strong>
          </span>

          <input type="submit" class="c-btnAuth c-btn" value="ユーザー登録" />
        </form>
      </div>
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