
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
<!--ーーーーーーーーーーーーーーーーーー マイページ画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-mypage"> 
      <p class="p-mypage__title">マイページ</p>
<!-- --------------------------------- 登録したSTEP -------------------------------- -->
      <div class="p-myStepWrap">
        <i class="fas fa-caret-left p-myStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-myStepWrap__arrowRight"></i>
        <p class="p-myStepWrap__title">登録したSTEP</p>
        <div class="p-stepContainer">
@for($i = 0; $i < 3; $i++)
        <div class="c-step">
          <img src="./images/rika.png" alt="" class="c-step__img">
          
          <div class="c-itemCover">
            <p class="c-itemCover__outline">
              気温や湿度を入力し、最も目覚めの良いアラームを自動で選択し…
            </p>
            <a href="#" class="c-itemCover__link">詳細を見る<i class="fas fa-search-plus c-coverIcon"></i></a>
          </div>
            
          <div class="c-step__wrap p-step__wrap">
            <div class="c-faceicon">
              <img src="./images/icon.png" alt="" class="c-faceicon__img">
            </div>
            <span class="c-stepTitle">サルでる分かる英語勉強法！</span>
            <div class="c-indexContainer">
              <span class="c-indexContainer__category c-category">英会話</span>
              <div class="c-favContainer">
                <i class="fas fa-star c-favContainer__icon c-star"></i>
                <span class="c-favContainer__total">48</span>
              </div>
            </div>
          </div>
        </div>
@endfor
       </div>
    　</div>
<!-- --------------------------------- チャレンジ中STEP -------------------------------- -->
      <div class="p-challengeStepWrap">
        <i class="fas fa-caret-left p-challengeStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-challengeStepWrap__arrowRight"></i>
        <p class="p-challengeStepWrap__title">チャレンジ中STEP</p>
        <div class="p-stepContainer">
@for($i = 0; $i < 3; $i++)
          <div class="c-step">
            <img src="./images/rika.png" alt="" class="c-step__img">
            
            <div class="c-itemCover">
              <p class="c-itemCover__outline">
                気温や湿度を入力し、最も目覚めの良いアラームを自動で選択し…
              </p>
              <a href="#" class="c-itemCover__link">詳細を見る<i class="fas fa-search-plus c-itemCover__icon"></i></a>
            </div>
              
            <div class="c-step__wrap p-step__wrap p-step__wrap--big">
              <div class="c-faceicon">
                <img src="./images/icon.png" alt="" class="c-faceicon__img">
              </div>
              <span class="c-stepTitle">サルでる分かる英語勉強法！</span>
              <div class="p-gaugeContainer">
                <span class="p-stepPercent">90%達成中/残り10%</span>
                <div class="p-gauge">
                  <span class="p-gauge__label">0%</span>
                  <span class="p-gauge__fill">
                    <span class="p-gauge__fill--label">0%</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
@endfor
       </div>
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