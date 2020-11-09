<template>
  <div class="l-bg p-authForm">
    <div class="p-authForm__container">
      <p class="c-formTitle">ログイン</p>

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
          class="c-form__input"
          　required
          autocomplete="current-password"
          placeholder="※7文字以上半角英数字"
        />

        <span class="c-invalid" role="alert">
          <strong>※パスワードが違います</strong>
        </span>

        <p class="c-form__passlink">
          ※パスワードを忘れた方は
          <a href="#" class="c-passLink">こちら</a>
        </p>

        <label for="c-formCheck" class="c-form__label">
          <input type="checkbox" name="remember" id="c-formCheck" />次回から自動でログインする
        </label>

        <input type="submit" class="c-btn c-btnAuth" value="ログイン" />
      </form>
      <span class="p-registerLink">
        →
        <a href="#" class="p-registerLink__link">ユーザー登録</a>
      </span>
    </div>
  </div>
</template>