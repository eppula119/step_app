<template>
  <main class="l-form">
    <div class="l-bg p-authForm">
      <div class="p-authForm__container">
        <p class="c-formTitle">{{ title }}</p>
        <!-------------------------------------- ログインフォーム ----------------------------------------------->
        <form
          method="post"
          class="c-form"
          @submit.prevent="login"
          v-show="tab === 1"
        >
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
            placeholder="※8文字以上32文字以下の半角英数字"
            v-model="loginForm.password"
          />

          <span class="c-invalid" role="alert" v-if="loginErrors">
            <ul v-if="loginErrors.password">
              <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </span>

          <p class="c-form__passlink">
            ※パスワードを忘れた方は
            <a href="#" class="c-passLink" @click.prevent="changeReminder"
              >こちら</a
            >
          </p>

          <label for="c-formCheck" class="c-form__label">
            <input
              type="checkbox"
              name="remember"
              id="c-formCheck"
            />次回から自動でログインする
          </label>

          <input type="submit" class="c-btn c-btnAuth" value="ログイン" />
        </form>
        <span class="p-registerLink" v-show="tab === 1">
          →
          <a href="#" class="p-registerLink__link" @click.prevent="changeForm"
            >ユーザー登録へ</a
          >
        </span>
        <!-------------------------------------- ユーザー登録フォーム ----------------------------------------------->
        <form
          method="post"
          class="c-form"
          @submit.prevent="register"
          v-show="tab === 2"
        >
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
            placeholder="※8文字以上32文字以下の半角英数字"
            v-model="registerForm.password"
          />

          <span class="c-invalid" role="alert" v-if="registerErrors">
            <ul v-if="registerErrors.password">
              <li v-for="msg in registerErrors.password" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>

          <span class="c-form__heading">パスワード再入力</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※8文字以上32文字以下の半角英数字"
            v-model="registerForm.password_confirmation"
          />
          <input type="submit" class="c-btnAuth c-btn" value="ユーザー登録" />
        </form>
        <span class="p-registerLink" v-show="tab === 2">
          →
          <a href="#" class="p-registerLink__link" @click.prevent="changeForm"
            >ログインへ</a
          >
        </span>
        <!-------------------------------------- パスワード忘れた場合のフォーム ----------------------------------------------->
        <form
          method="post"
          class="c-form"
          @submit.prevent="forgot"
          v-show="tab === 3"
        >
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
            v-model="forgotForm.email"
          />

          <span class="c-invalid" role="alert" v-if="forgotErrors">
            <ul v-if="forgotErrors.email">
              <li v-for="msg in forgotErrors.email" :key="msg">{{ msg }}</li>
            </ul>
          </span>

          <p class="c-form__comment">
            ご登録メールアドレスを送信してください。後ほど再設定のためのリンクを記載したメールを送らせていただきます。
          </p>

          <input type="submit" class="c-btn c-btnAuth" value="送信" />
        </form>
        <span class="p-registerLink" v-show="tab === 3">
          →
          <a href="#" class="p-registerLink__link" @click.prevent="changeForm"
            >ログインへ</a
          >
        </span>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      tab: 1,
      title: "ログイン",
      loginForm: {
        email: "",
        password: "",
      },
      registerForm: {
        email: "",
        password: "",
        password_confirmation: "",
      },
      forgotForm: {
        email: "",
      },
    };
  },

  computed: mapState({
    apiStatus: (state) => state.auth.apiStatus,
    loginErrors: (state) => state.auth.loginErrorMessages, // ログインエラーメッセージstatusを参照
    registerErrors: (state) => state.auth.registerErrorMessages, // ユーザー登録エラーメッセージstatusを参照
    forgotErrors: (state) => state.auth.forgotErrorMessages, // パスワード変更エラーメッセージstatusを参照
  }),

  methods: {
    async login() {
      await this.$store.dispatch("auth/login", this.loginForm); // authストアのloginアクションを呼び出す
      if (this.apiStatus) {
        this.$router.push("/step_list"); // 通信成功したら、STEP一覧ページに移動する
      }
    },
    async register() {
      await this.$store.dispatch("auth/register", this.registerForm); // authストアのresigterアクションを呼び出す

      if (this.apiStatus) {
        this.$router.push("/step_list"); // 新規登録後、STEP一覧ページに移動する
      }
    },
    async forgot() {
      console.log("メール送信API発動");
      alert("forgot");
      await this.$store.dispatch("auth/forgot", this.forgotForm); // authストアのforgotアクションを呼び出す
      if (this.apiStatus) {
        this.$store.commit("message/setContent", {
          content: "パスワードリセットメールを送りました。",
          timeout: 10000,
        });
        this.clearError(); // AUTHストアのエラーメッセージをクリア
      }
    },
    clearError() {
      // エラーメッセージをクリア
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
      this.$store.commit("auth/setForgotErrorMessages", null);
    },
    async changeForm() {
      if (this.tab === 1) {
        // ログイン画面表示中の場合、ユーザー登録画面に切替
        this.title = "ユーザー登録";
        return (this.tab = 2);
      }
      if (this.tab === 2 || this.tab === 3) {
        // ユーザー登録画面またはパスワード再設定画面表示中の場合、ログイン画面に切替
        console.log("ユーザー登録画面のため、ログイン画面へ");
        this.title = "ログイン";
        return (this.tab = 1);
      }
    },
    async changeReminder() {
      // パスワードリマインダー画面へ
      console.log("パスワードリマインダー画面へ");
      this.title = "パスワード再設定";
      return (this.tab = 3);
    },
  },
  created() {
    this.clearError();
  },
};
</script>