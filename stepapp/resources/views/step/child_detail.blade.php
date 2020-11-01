
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>子STEP詳細</title>
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
<!--ーーーーーーーーーーーーーーーーーー STEP詳細画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-stepForm">
      <p class="p-stepForm__title">猿でも分かる英会話</p>
        <div class="p-childContainer">
          <div class="p-childContainer__index">
            <span class="p-childTitle">STEP:1</span>
            <span class="p-childTime">目標時間：30分</span>
          </div>
          <p class="p-childContainer__title">兎にも角にもまずはリスニング</p>
    <!--ーーーーーーーーーーーーーーーーーー 内容部分 ーーーーーーーーーーーーーーーーーー--> 
          <div class="p-childContainer__content">
            <span class="p-childContent">中学生向けの英会話勉強法です。<br/>学生のうちに身につけておくと<br/>今後何十年と大人になっても使えます。</span>
        　</div>
    <!-- --------------------------------- 画像部分 -------------------------------- -->
          <div class="p-childContainer__img">
            <img src="./images/rika.png" alt="" class="p-childImage">   
        　</div>
   
    <!-- ---------------------------------ボタン部分 -------------------------------- -->
          <button type="submit" class="c-btnEntry c-btn p-clearBtn">クリア</button>
          <button type="submit" class="c-btn p-snsBtn"><i class="fab fa-twitter"></i>Twitterでシェアする</button>
          <button type="submit" class="c-btn p-nextBtn">→STEP2へ</button>
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