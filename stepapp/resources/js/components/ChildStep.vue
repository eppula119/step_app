<template>
  <!--ーーーーーーーーーーーーーーーーーー STEP詳細画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-main">
    <div class="l-bg p-stepForm">
      <p class="p-stepForm__title">{{ steps.title }}</p>
      <div
        class="p-childContainer"
        　v-for="(item, i) in filterChilds"
        :key="i"
      >
        <div class="p-childContainer__index">
          <span class="p-childTitle">STEP:1</span>
          <span class="p-childTime">目標時間：{{ item.time }}分</span>
        </div>
        <p class="p-childContainer__title">{{ item.title }}</p>
        <!--ーーーーーーーーーーーーーーーーーー 内容部分 ーーーーーーーーーーーーーーーーーー-->
        <div class="p-childContainer__content">
          <span class="p-childContent">{{ item.content }}</span>
        </div>
        <!-- --------------------------------- 画像部分 -------------------------------- -->
        <div class="p-childContainer__img">
          <img :src="item.image" alt class="p-childImage" />
        </div>

        <!-- ---------------------------------ボタン部分 -------------------------------- -->
        <button
          type="submit"
          class="c-btnEntry c-btn p-clearBtn"
          @click="clear(item.id)"
        >
          クリア
        </button>
        <button type="submit" class="c-btn p-snsBtn" @click="twitterShare">
          <i class="fab fa-twitter"></i>Twitterでシェアする
        </button>
        <button type="submit" class="c-btn p-nextBtn" @click.prevent="onPrev">
          →STEP1へ
        </button>
        <button type="submit" class="c-btn p-nextBtn" @click.prevent="onNext">
          →STEP2へ
        </button>
      </div>
    </div>
  </main>
</template>

<script>
import { OK } from "../util";
import { mapState } from "vuex";

export default {
  props: {
    step_id: {
      type: String,
      required: true,
    },
  },
  data() {
    const perPage = 1; // 表示する子STEP件数
    return {
      child: {
        time: "",
        content: "",
        title: "",
        image: "",
        step: { title: "" },
      },
      // currentPage: this.page,
      page: 1, //　現在の子STEP番号
      perPage, // 表示する子STEP件数
      totalPage: null, // 総ページ数
      count: null, // 子STEPの総数
    };
  },
  computed: {
    // stepストアのstepsを参照
    ...mapState({
      childs: (state) => state.step.childSteps,
      steps: (state) => state.step.steps,
    }),
    filterChilds() {
      // 閲覧画面に表示させる子STEPを表示。(次の子STEP遷移機能)
      console.log("fileterchildsが変化した");
      console.log(this.childs);
      return this.childs.filter(
        (item, i) =>
          i >= (this.page - 1) * this.perPage && i < this.page * this.perPage
      );
    },
    prevPage() {
      return Math.max(this.page - 1, 1);
    },
    nextPage() {
      return Math.min(this.page + 1, this.totalPage);
    },
  },
  methods: {
    async fetchChildStep() {
      console.log("childDetail通信開始");
      const response = await axios.get(
        `/api/step_list/step=${this.step_id}/child`
      );

      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      console.log("レスポンスデータ");
      console.log(response.data.child);
      this.$store.commit("step/setChildSteps", response.data.child);
      this.child = response.data.child;
      this.count = this.childs.length;
      console.log("トータルページ");
      this.totalPage = Math.ceil(this.childs.length / this.perPage);
      console.log(this.totalPage);
    },
    // クリア
    async clear(id) {
      console.log("クリア開始");
      console.log(id);
      const response = await axios.post(`/api/clear/${id}`);
      console.log(response.data);
      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      console.log("次の子STEPへ遷移開始");
      this.page = this.nextPage;
      // this.$router.push(
      //   `/step_list/step=${this.step.id}/child=${this.step.child[0].id}`
      // );
    },
    onPrev() {
      this.page = this.prevPage;
    },
    onNext() {
      console.log("次のページへクリックされたよ");
      this.page = this.nextPage;
      // this.$router.push(`/step_list/step=${this.step_id}/child=${this.page}`);
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
        await this.fetchChildStep();
      },
      immediate: true,
    },
  },
};
</script>