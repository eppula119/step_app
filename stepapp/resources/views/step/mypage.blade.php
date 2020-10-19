
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>マイページ</title>
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
<!--ーーーーーーーーーーーーーーーーーー マイページ画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-stepForm"> 
      <p class="p-stepForm__title">マイページ</p>
<!-- --------------------------------- 登録したSTEP -------------------------------- -->
      <div class="p-myStepWrap">
        <i class="fas fa-caret-left p-challengeStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-challengeStepWrap__arrowRight"></i>
        <p class="p-myStepWrap__title">登録したSTEP</p>
   　   @for($i = 0; $i < 3; $i++)
        <div class="p-step">
          <img src="./images/rika.png" alt="" class="p-step__img">
          
          <div class="p-itemCover">
            <p class="p-itemCover__outline">
              気温や湿度を入力し、最も目覚めの良いアラームを自動で選択し…
            </p>
            <a href="#" class="p-itemCover__link">詳細を見る<i class="fas fa-search-plus p-itemCover__icon"></i></a>
          </div>
            
          <div class="p-step__wrap">
            <div class="p-faceicon">
              <img src="./images/icon.png" style="width: 50px;" alt="" class="p-faceicon__img">
            </div>
            <span class="p-stepTitle">サルでる分かる英語勉強法！</span>
            <span class="p-stepCategory c-category">英会話</span>
            <i class="fas fa-star p-stepFav c-star"></i><span class="p-stepTotal">48</span>
          </div>
        </div>
       @endfor
    　</div>
<!-- --------------------------------- チャレンジ中STEP -------------------------------- -->
      <div class="p-challengeStepWrap">
        <i class="fas fa-caret-left p-challengeStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-challengeStepWrap__arrowRight"></i>
        <p class="p-challengeStepWrap__title">チャレンジ中STEP</p>
   　   @for($i = 0; $i < 3; $i++)
        <div class="p-step">
          <img src="./images/rika.png" alt="" class="p-step__img">
          
          <div class="p-itemCover">
            <p class="p-itemCover__outline">
              気温や湿度を入力し、最も目覚めの良いアラームを自動で選択し…
            </p>
            <a href="#" class="p-itemCover__link">詳細を見る<i class="fas fa-search-plus p-itemCover__icon"></i></a>
          </div>
            
          <div class="p-step__wrap">
            <div class="p-faceicon">
              <img src="./images/icon.png" style="width: 50px;" alt="" class="p-faceicon__img">
            </div>
            <span class="p-stepTitle">サルでる分かる英語勉強法！</span>
            <span class="p-stepPercent">90%達成中/残り10%</span>
            <div class="p-gauge">
              <span class="p-gauge__label">0%</span>
              <span class="p-gauge__fill">
                <span class="p-gauge__fill--label">0%</span>
              </span>
            </div>
          </div>
        </div>
       @endfor
    　</div>
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