
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>TOP</title>
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
 <!--ーーーーーーーーーーーーーーーーーーー　サービス名 ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-hero">
      <img src="./images/logo.png" style="width: 100px;" alt="" class="p-heroImg">
      <p class="p-heroTitle">あなたに合った学び方が見つかる</p>
    </section>
    <!--ーーーーーーーーーーーーーーーーーーー Service ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-service">
      <img src="./images/top_pen.png" style="width: 100px;" alt="" class="p-serviceImg1">
      <div class="p-serviceWrap1">
        <p class="p-serviceWrap1__heading">STEPは無料</p>
        <span class="p-serviceWrap1__text">
          他人の知恵と経験が詰まった<br>
          様々なSTEPを全て無料で<br>
          誰でも簡単に見る事が出来ます。
        </span>
      </div>

    </section>
    
    <!--ーーーーーーーーーーーーーーーーーーー グラフ ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-data">
    <div class="p-dataWrap">
        <p class="p-dataWrap__text">
          ある統計データでは、中学生の学習上での悩みの<br/>半分以上はh上手な勉強のやり方がわからないと回答。
        </p>
        <img src="./images/data.png" style="width: 100px;"  alt="" class="p-dataWrap__img">
      </div>
    </section>
  
    <!--ーーーーーーーーーーーーーーーーーーー 機能紹介 ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-produce">
      <div class="p-produceContainer">
        <p class="p-produceContainer__heading">細かい仕様も搭載</p>
        <div class="p-produceContainer__wrap">
          <div class="p-produceCard">
            <p class="p-produceCard__heading">子STEP機能</p>
            <span class="p-produceCard__text">
              ステップに紐づく子ステップを<br/>１つずつクリアしながら学習を<br/>進めることができます。
            </span>
            <img src="./images/logo.png" style="width: 100px;" alt="" class="p-produceCard__img">
          </div>
          <div class="p-produceCard">
            <p class="p-produceCard__heading">カテゴリーも豊富</p>
            <span class="p-produceCard__text">
              学校で勉強以外にも健康法や<br/>ダイエット、筋トレ、ギター、<br/>英会話など様々なSTEPの<br/>閲覧が可能です。
            </span>
            <img src="./images/logo.png" style="width: 100px;" alt="" class="p-produceCard__img">
          </div>
          <div class="p-produceCard">
            <p class="p-produceCard__heading">自分のSTEPをシェア</p>
            <span class="p-produceCard__text">
              あなたが今まで培ってきた、学習法を<br/>同じ悩みを持った人へSTEPを登録し<br/>シェアしよう
            </span>
            <img src="./images/logo.png" style="width: 100px;" alt="" class="p-produceCard__img">
          </div>
        </div>
      </div>
    </section>

    <!--ーーーーーーーーーーーーーーーーーーー 「今すぐ始める」ボタン ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-start">
      <img src="./images/logo.png" style="width: 100px;"  alt="" class="p-startImg">
      <button class="c-btn p-startBtn">今すぐ始める</button>
    </section>

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