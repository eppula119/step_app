
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>STEP詳細</title>
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
            <img src="./images/logo.png" style="width: 100px; height: 100px;" alt class="p-topLink__img" />
          </a>
        </div>
        <div class="p-header__search">
          <form action="" class="p-search">
            @csrf
            <input type="text" class="p-search__form">
            <button  type="submit" class="p-search__form">検索</button>
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
      <div class="p-indexContainer">
        <span class="p-indexContainer__category c-category">英会話</span>
        <span class="p-indexContainer__time">目標時間：160時間</span>
        <span class="p-indexContainer__fav"><i class="fas fa-heart p-fav"></i></span>
      </div>
      <p class="p-detailTitle">猿でも分かる英会話！</p>
<!--ーーーーーーーーーーーーーーーーーー 内容部分 ーーーーーーーーーーーーーーーーーー--> 
      <div class="p-detailContent">
        <span class="p-detailContent__text">中学生向けの英会話勉強法です。<br/>学生のうちに身につけておくと<br/>今後何十年と大人になっても使えます。</span>
    　</div>
<!-- --------------------------------- 画像部分 -------------------------------- -->
      <div class="p-detailImage">
        <img src="./images/rika.png" alt="" class="p-detailImage__img">   
    　</div>
@for($i = 0; $i < 3; $i++)
      <div class="p-childStep">
        <span class="p-childStep__number">STEP:1</span>
        <span class="p-childStep__title">兎にも角にもまずはリスニング！</span>
      </div>
@endfor
      <button type="submit" class="c-btnEntry c-btn">チャレンジする</button>
      <button type="submit" class="c-btn p-snsBtn"><i class="fab fa-twitter"></i>Twitterでシェアする</button>
  　</div>
  </main>


  <div class="l-footer">
      <ul class="p-footerMenu">
        <li class="p-footerMenu__list">特定商取引法</li>
        <li class="p-footerMenu__list">プライバシーポリシー</li>
        <li class="p-footerMenu__list">Step</li>
      </ul>
  </div>
</div>

</body>
</html>