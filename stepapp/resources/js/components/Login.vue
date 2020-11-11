<template>
  <main class="l-form">
    <div class="l-bg p-authForm">
      <div class="p-authForm__container">
        <p class="c-formTitle">ログイン</p>
        <!-------------------------------------- ログインフォーム ----------------------------------------------->
        <form method="post" class="c-form" @submit.prevent="login" v-show="tab == false">
          <span class="c-form__heading">メールアドレス</span>
          <input
            type="email"
            name="email"
            class="c-form__input is-invalid"
            required
            autocomplete="email"
            autofocus
            placeholder="例：hogehoge@gmail.com"
            v-model="loginForm.email"
          />

          <span class="c-invalid" role="alert" v-if="loginErrors">
            <ul v-if="loginErrors.email">
              <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
            </ul>
          </span>

          <span class="c-form__heading">パスワード</span>
          <input
            type="password"
            name="password"
            class="c-form__input"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
            v-model="loginForm.password"
          />

          <span class="c-invalid" role="alert" v-if="loginErrors">
            <ul v-if="loginErrors.password">
              <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
            </ul>
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
        <span class="p-registerLink" v-show="tab == false">
          →
          <a href="#" class="p-registerLink__link">ユーザー登録</a>
        </span>
        <!-------------------------------------- ユーザー登録フォーム ----------------------------------------------->
        <form method="post" class="c-form" @submit.prevent="register" v-show="tab === true">
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
            v-model="registerForm.email"
          />

          <span class="c-invalid" role="alert" v-if="registerErrors">
            <ul v-if="registerErrors.email">
              <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
            </ul>
          </span>

          <span class="c-form__heading">パスワード</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
            v-model="registerForm.password"
          />

          <span class="c-invalid" role="alert" v-if="registerErrors">
            <ul v-if="registerErrors.password">
              <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </span>

          <span class="c-form__heading">パスワード再入力</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
            v-model="registerForm.password_confirmation"
          />
          <span class="c-invalid" role="alert">
            <strong>※パスワードが違います</strong>
          </span>

          <input type="submit" class="c-btnAuth c-btn" value="ユーザー登録" />
        </form>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      tab: true,
      loginForm: {
        email: "",
        password: ""
      },
      registerForm: {
        email: "",
        password: "",
        password_confirmation: ""
      }
    };
  },

  computed: mapState({
    apiStatus: state => state.auth.apiStatus,
    loginErrors: state => state.auth.loginErrorMessages, // ログインエラーメッセージstatusを参照
    registerErrors: state => state.auth.registerErrorMessages // ユーザー登録エラーメッセージstatusを参照
  }),

  methods: {
    async login() {
      await this.$store.dispatch("auth/login", this.loginForm); // authストアのloginアクションを呼び出す
      if (this.apiStatus) {
        this.$router.push("/"); // 通信成功したら、トップページに移動する
      }
    },
    async register() {
      await this.$store.dispatch("auth/register", this.registerForm); // authストアのresigterアクションを呼び出す

      if (this.apiStatus) {
        this.$router.push("/"); // トップページに移動する
      }
    },
    clearError() {
      // エラーメッセージをクリア
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
    }
  },
  created() {
    this.clearError();
  }
};
</script>