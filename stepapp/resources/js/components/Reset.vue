<template>
  <main class="l-form">
    <div class="l-bg p-authForm">
      <div class="p-authForm__container">
        <p class="c-formTitle">パスワードリセット</p>
        <!-------------------------------------- パスワードリセットフォーム ----------------------------------------------->
        <form method="post" class="c-form" @submit.prevent="reset">
          <span class="c-form__heading">新規パスワード</span>
          <input
            type="password"
            name="password"
            class="c-form__input is-invalid"
            　required
            autocomplete="current-password"
            placeholder="※7文字以上半角英数字"
            v-model="resetForm.password"
          />

          <span class="c-invalid" role="alert" v-if="resetErrors">
            <ul v-if="resetErrors.password">
              <li v-for="msg in resetErrors.password" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="resetErrors.token">
              <li v-for="msg in resetErrors.token" :key="msg">{{ msg }}</li>
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
            v-model="resetForm.password_confirmation"
          />
          <span class="c-invalid" role="alert">
            <strong>※パスワードが違います</strong>
          </span>

          <input type="submit" class="c-btnAuth c-btn" value="パスワードリセット" />
        </form>
      </div>
    </div>
  </main>
</template>

<script>
import Cookies from "js-cookie";

export default {
  data() {
    return {
      resetForm: {
        password: "",
        password_confirmation: "",
        token: ""
      }
    };
  },
  computed: {
    // authストアのapiStatus
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    // authストアのresetErrorMessages
    resetErrors() {
      return this.$store.state.auth.resetErrorMessages;
    }
  },
  methods: {
    async reset() {
      // authストアのresetアクションを呼び出す
      await this.$store.dispatch("auth/reset", this.resetForm);
      // 通信成功
      if (this.apiStatus) {
        // メッセージストアで表示
        this.$store.commit("message/setContent", {
          content: "パスワードをリセットしました。",
          timeout: 10000
        });
        // AUTHストアのエラーメッセージをクリア
        this.clearError();
        // フォームをクリア
        this.clearForm();
        // トップページに移動
        this.$router.push("/");
      }
    },
    clearError() {
      // AUTHストアのエラーメッセージをクリア
      this.$store.commit("auth/setResetErrorMessages", null);
    },
    clearForm() {
      // reset
      this.resetForm.password = "";
      this.resetForm.password_confirmation = "";
      this.resetForm.token = "";
    }
  },
  created() {
    // クッキーからリセットトークンを取得
    const token = Cookies.get("RESETTOKEN");
    // リセットトークンがない場合はルートページへ移動させる
    if (this.resetForm.token == null) {
      // move to home
      this.$router.push("/");
    }
    // フォームにリセットトークンをセット
    this.resetForm.token = token;
    // リセットトークンをクッキーから削除
    if (token) {
      Cookies.remove("RESETTOKEN");
    }
  }
};
</script>