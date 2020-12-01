<template>
  <header class="l-header" v-bind:class="{'p-headerList':stepList}">
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
        <button class="p-menuBtn" v-on:click="isActive = !isActive">メニュー</button>
        <div class="p-headerMenu" v-bind:class="{active: isActive}">
          <ul class="p-headerMenu__list" v-show="isActive">
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
      <div class="p-headerMenuTrigger js-toggle-sp-menu" v-on:click="isActive = !isActive">
        <span class="p-headerMenuTrigger__border" v-bind:class="{active: isActive}"></span>
        <span class="p-headerMenuTrigger__border" v-bind:class="{active: isActive}"></span>
        <span class="p-headerMenuTrigger__border" v-bind:class="{active: isActive}"></span>
      </div>
    </div>

    <StepSort />
  </header>
</template>

<script>
import StepSort from "../components/StepSort.vue";
import { mapState, mapGetters } from "vuex";
export default {
  components: {
    StepSort
  },
  data() {
    return {
      isActive: false
    };
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      stepList: state => state.paging.stepList
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
  },
  watch: {
    // ルート変更を監視
    $route(to, from) {
      this.isActive = false; // ルート変更時、メニューを閉じる
    }
  }
};
</script>