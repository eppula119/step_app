<template>
  <div>
    <!--ーーーーーーーーーーーーーーーーーー STEP一覧画面表示 ーーーーーーーーーーーーーーーーーー-->
    <section class="l-hero">
      <img src="images/logo.png" alt="" class="p-heroImg" />
      <p class="p-heroTitle">あなたに合った学び方が見つかる</p>
    </section>
    <!--ーーーーーーーーーーーーーーーーーーー Service ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-service">
      <img src="images/top_pen.png" alt="" class="p-serviceImg1" />
      <div class="p-serviceWrap1">
        <p class="p-serviceWrap1__heading">STEPは無料</p>
        <span class="p-serviceWrap1__text">
          他人の知恵と経験が詰まった<br />
          様々なSTEPを全て無料で<br />
          誰でも簡単に見る事が出来ます。
        </span>
      </div>
    </section>

    <!--ーーーーーーーーーーーーーーーーーーー データ ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-data">
      <div class="p-dataWrap">
        <p class="p-dataWrap__text">
          ある統計データでは、中学生の学習上での悩みの<br />半分以上はh上手な勉強のやり方がわからないと回答。
        </p>
        <img src="images/data.png" alt="" class="p-dataWrap__img" />
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
              ステップに紐づく子ステップを１つずつクリアしながら学習を進めることができます。
            </span>
            <img
              src="images/childSteps.png"
              alt=""
              class="p-produceCard__img"
            />
          </div>
          <div class="p-produceCard">
            <p class="p-produceCard__heading">カテゴリーも豊富</p>
            <span class="p-produceCard__text">
              学校で勉強以外にも健康法やダイエット、筋トレ、ギター、英会話など様々なSTEPの閲覧が可能です。
            </span>
            <img src="images/category.png" alt="" class="p-produceCard__img" />
          </div>
          <div class="p-produceCard">
            <p class="p-produceCard__heading">自分のSTEPをシェア</p>
            <span class="p-produceCard__text">
              あなたが今まで培ってきた、学習法を同じ悩みを持った人へSTEPを登録しシェアしよう
            </span>
            <img src="images/mihon.png" alt="" class="p-produceCard__img" />
          </div>
        </div>
      </div>
    </section>

    <!--ーーーーーーーーーーーーーーーーーーー 「今すぐ始める」ボタン ーーーーーーーーーーーーーーーーーーーーーー-->
    <section class="l-start">
      <img src="images/logo.png" alt="" class="p-startImg" />
      <button class="c-btn p-startBtn" @click="start">今すぐ始める</button>
    </section>
    <!--ーーーーーーーーーーーーーーーーーーー フッター ーーーーーーーーーーーーーーーーーーーーーー-->
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapState({
      top: (state) => state.paging.top,
    }),
  },
  methods: {
    // 全てのアイディアを取得
    async fetchTop() {
      this.$store.dispatch("paging/changeTop", true);
    },
    async start() {
      this.$store.dispatch("paging/changeTop", false);
      this.$router.push("/login").catch((err) => console.log(err));
    },
  },
  watch: {
    $route: {
      async handler(to, from) {
        console.log(from);
        console.log("$routeが変わった");
        await this.fetchTop();
        console.log(to);
      },
      immediate: true, // 起動時にも実行
    },
  },
};
</script>