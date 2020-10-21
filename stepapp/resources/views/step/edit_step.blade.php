
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

  <main class="l-main">
<!--ーーーーーーーーーーーーーーーーーー STEP編集画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-stepForm"> 
  
      <form class="p-registerStep">
      @csrf
        <p class="p-registerStep__heading">タイトル</p>
        <input type="text" name="title" class="p-registerStep__title" placeholder="STEP名" />
        <span class="c-invalid p-titleMsg" role="alert">
          <strong>30文字以内で入力して下さい</strong>
        </span>

　　　　　<p class="p-registerStep__heading">内容</p>
         <textarea
          class="p-registerStep__content" name="content"　cols="30"　rows="10" placeholder="内容"
        ></textarea>
        <span class="c-invalid p-contentMsg" role="alert">
          <strong>1万文字以内</strong>
        </span>

        <p class="p-registerStep__heading">画像</p>
        <div class="p-fileContainer">
          <label class="p-fileContainer__airDrop">
            ドラッグ＆ドロップ
            <input type="file" class="p-dropImg" name="image"/>
            <output class="p-outputImg">
              <img class="p-outputImg__img"/>
            </output>
          </label>
          <span class="c-invalid p-fileContainer__msg" role="alert">
            <strong>画像の容量は10MB以内に抑えてください。</strong>
          </span>
        </div>

        <p class="p-registerStep__heading">カテゴリー</p>
        <select name="category_id" class="p-registerStep__category">
          <option value="1" class="p-selectCategory">勉強</option>
          <option value="2" class="p-selectCategory">ダイエット</option>
          <option value="3" class="p-selectCategory">筋トレ</option>
          <option value="4" class="p-selectCategory">英会話</option>
          <option value="5" class="p-selectCategory">ギター</option>
          <option value="6" class="p-selectCategory">ビジネス</option>
          <option value="7" class="p-selectCategory">弁護士</option>
        </select>

        <p class="p-registerStep__heading">目標時間(単位：時間)</p>
        <div class="p-registerStep__time">
          <input
            type="number"
            name="time"
            class="p-stepTime"
            placeholder="例：120"
          />
        <span class="c-invalid p-timeMsg" role="alert">
          <strong>小数点第1位まで入力可能です。</strong>
        </span>
        </div>
        <button type="submit" class="c-btnEntry c-btn c-btn--white">次の子STEPへ→</button>
        <div class="p-btnContainer">
          <button type="submit" class="c-btnEntry c-btn p-btnContainer__delete">削除</button>
          <button type="submit" class="c-btnEntry c-btn p-btnContainer__update">更新</button>
        </div>
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