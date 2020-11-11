<template>
  <header class="l-header">
    <div class="p-header">
      <div class="p-header__logo">
        <RouterLink class="p-topLink" to="/">
          <img src="images/logo.png" alt class="p-topLink__img" />
        </RouterLink>
      </div>
      <div class="p-header__search">
        <form action class="p-search">
          <input type="text" class="p-search__form" />
          <button type="submit" class="p-search__btn">検索</button>
        </form>
      </div>
      <div class="p-header__menu">
        <button class="p-menuBtn">メニュー</button>
        <div class="p-headerMenu">
          <ul class="p-headerMenu__list">
            <li class="p-menuItem">マイページ</li>
            <li class="p-menuItem">トップページ</li>
            <li class="p-menuItem">ユーザー登録</li>
            <li class="p-menuItem" v-if="isLogin">
              <form action method="POST" @submit.prevent="logout">
                <button type="submit" class="p-logout c-btn">ログアウト</button>
              </form>
            </li>
            <li class="p-menuItem" v-else>
              <RouterLink to="/login">ログイン</RouterLink>
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
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      tab: 1
    };
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus
    }),
    ...mapGetters({
      isLogin: "auth/check" //ログインしているかチェック
    })
  },
  methods: {
    async logout() {
      // authストアのlogoutアクションを呼び出す
      await this.$store.dispatch("auth/logout");

      if (this.apiStatus) {
        // ログインページに移動する
        console.log("ログアウトしたためログインページへ移動");
        this.$router.push("/login");
      }
    }
  }
};
</script>