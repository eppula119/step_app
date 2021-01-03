<template>
  <!--ーーーーーーーーーーーーーーーーーー STEP詳細画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-main">
    <div class="l-bg p-stepForm">
      <div class="p-indexContainer">
        <span class="p-indexContainer__category c-category">英会話</span>
        <span class="p-indexContainer__time"
          >目標時間：{{ step.time }}時間</span
        >
        <span
          class="p-indexContainer__fav"
          :class="{ 'p-indexContainer--favorited': step.favorited_by_user }"
          @click="onFavoriteClick"
        >
          <i class="fas fa-heart p-fav"></i>
        </span>
      </div>
      <p class="p-detailTitle">{{ step.title }}</p>
      <!--ーーーーーーーーーーーーーーーーーー 内容部分 ーーーーーーーーーーーーーーーーーー-->
      <div class="p-detailContent">
        <span class="p-detailContent__text">{{ step.content }}</span>
      </div>
      <!-- --------------------------------- 画像部分 -------------------------------- -->
      <div class="p-detailImage">
        <img :src="step.image" alt class="p-detailImage__img" />
      </div>
      <!-- --------------------------------- 子STEP一覧部分 -------------------------------- -->

      <div class="p-childStep" v-for="child in childs" :key="child.id">
        <RouterLink :to="`/step_list/step=${step.id}/child=${child.id}`">
          <span class="p-childStep__number">STEP:1</span>
          <span class="p-childStep__title">{{ child.title }}</span>
        </RouterLink>
      </div>
      <!-- ---------------------------------ボタン部分 -------------------------------- -->
      <div class="p-btnContainer" v-if="myStep">
        <button class="p-btnContainer__edit" @click="edit">編集</button>
      </div>
      <button
        type="submit"
        class="c-btnEntry c-btn p-btnChallenge"
        @click="challenge"
        v-else
      >
        チャレンジする
      </button>

      <button type="submit" class="c-btn p-snsBtn" @click="twitterShare">
        <i class="fab fa-twitter"></i>Twitterでシェアする
      </button>
    </div>
  </main>
</template>

<script>
import { OK } from "../util";
import { mapState, mapGetters } from "vuex";

export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      step: {
        time: "",
        content: "",
        title: "",
        image: "",
        child: {},
        favorites_count: 12,
        favorites_by_user: false,
      },
      myStep: false,
    };
  },
  computed: {
    ...mapGetters({
      // 現在、ログイン中かどうか参照
      isLogin: "auth/check",
    }),
    // stepストアのstepsを参照
    ...mapState({
      childs: (state) => state.step.childSteps,
      user: (state) => state.auth.user,
    }),
  },
  methods: {
    async fetchStep() {
      console.log("get通信開始");
      const response = await axios.get(`/api/step_list/${this.id}`);

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      console.log("response.data.stepのなかみ");
      console.log("response.data.step");
      console.log("response.data.childのなかみ");
      console.log(response.data.child);
      this.step = response.data.step;
      // 通信成功時、stepストアに子STEPを全てセット
      this.$store.dispatch("step/setSteps", response.data.step);
      this.$store.dispatch("step/setChildSteps", response.data.child);

      if (this.user.id === this.step.user_id) {
        // ログインユーザーが登録したSTEPは判定
        this.myStep = true;
      }
    },
    onFavoriteClick() {
      if (!this.isLogin) {
        alert("気になるボタンを使うにはログインしてください。");
        return false;
      }

      if (this.step.favorited_by_user) {
        this.unfavorite();
      } else {
        this.favorite();
      }
    },
    // 気になるリスト登録
    async favorite() {
      const response = await axios.put(`/api/step_list/${this.id}/favorite`);

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      this.step.favorited_by_user = true;
    },
    // 気になるリスト解除
    async unfavorite() {
      const response = await axios.delete(`/api/step_list/${this.id}/favorite`);

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }

      this.step.favorited_by_user = false;
    },
    // チャレンジする
    async challenge() {
      const response = await axios.post(`/api/challenge/${this.step.id}`);
      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      this.$router.push(`/step_list/step=${this.step.id}/child`);
    },
    // 編集画面へ遷移する
    async edit() {
      this.$router.push(`/register_step`);
    },
    // Twitterシェア
    async twitterShare() {
      //シェアする画面を設定
      var shareURL =
        "https://twitter.com/intent/tweet?text=" +
        "あなたに合った学習方法が見つかるかも？「STEP」" +
        "%20%23STEP" +
        "&url=" +
        "http://steps/twitter-share";
      //シェア用の画面へ移行
      location.href = shareURL;
    },
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchStep();
      },
      immediate: true,
    },
  },
};
</script>