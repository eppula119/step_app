<template>
  <main class="l-myPage">
    <!--ーーーーーーーーーーーーーーーーーー マイページ画面表示 ーーーーーーーーーーーーーーーーーー-->
    <div class="l-bg p-mypage">
      <p class="p-mypage__title">マイページ</p>
      <!-- --------------------------------- 登録したSTEP -------------------------------- -->
      <div class="p-myStepWrap">
        <i class="fas fa-caret-left p-myStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-myStepWrap__arrowRight"></i>
        <p class="p-myStepWrap__title">登録したSTEP</p>
        <div class="p-stepContainer">
          <!---------------------------------- ４つ表示 --------------------------------->

          <Step
            class="p-stepContainer__step"
            v-for="step in steps"
            :key="step.id"
            :item="step"
          />

          <!---------------------------------- 終了--------------------------------->
        </div>
        　
      </div>
      <!-- --------------------------------- お気に入りしたSTEP -------------------------------- -->
      <div class="p-favStepWrap">
        <i class="fas fa-caret-left p-favStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-favStepWrap__arrowRight"></i>
        <p class="p-favStepWrap__title">お気に入りSTEP</p>
        <div class="p-stepContainer">
          <!---------------------------------- ４つ表示 --------------------------------->

          <Step
            class="p-stepContainer__step"
            v-for="step in favSteps"
            :key="step.id"
            :item="step"
          />

          <!---------------------------------- 終了--------------------------------->
        </div>
        　
      </div>

      <!-- --------------------------------- チャレンジ中STEP -------------------------------- -->
      <div class="p-challengeStepWrap">
        <i class="fas fa-caret-left p-challengeStepWrap__arrowLeft"></i>
        <i class="fas fa-caret-right p-challengeStepWrap__arrowRight"></i>
        <p class="p-challengeStepWrap__title">チャレンジ中STEP</p>
        <div class="p-stepContainer">
          <!---------------------------------- ４つ表示 --------------------------------->
          <ChallengeStep
            class="p-stepContainer__step"
            v-for="step in challengeSteps"
            :key="step.id"
            :item="step"
          />

          <!---------------------------------- 終了--------------------------------->
        </div>
        　
      </div>
      　
    </div>
  </main>
</template>

<script>
import { OK } from "../util";

import { mapState, mapGetters } from "vuex";
import Step from "../components/Step.vue";
import ChallengeStep from "../components/ChallengeStep.vue";
export default {
  components: {
    Step,
    ChallengeStep,
  },
  props: {},
  data() {
    return {};
  },
  methods: {
    // 全てのstepを取得
    async fetchSteps() {
      const response = await axios.get("/api/mypage");
      console.log("api読み込み");
      console.log(response.data);
      //　レスポンスエラーの場合エラーstateにstatusをセット
      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        console.log("エラー");
        return false;
      }
      console.log("登録したSTEP");
      console.log(response.data.myStep);
      console.log("お気に入りSTEP");
      console.log(response.data.favStep);
      // 通信成功時、stepストアにアイディア全てセット
      this.$store.dispatch("step/setSteps", response.data.myStep);
      this.$store.dispatch("step/setFavSteps", response.data.favStep);
      this.$store.dispatch(
        "step/setChallengeSteps",
        response.data.challengeStep
      );
      console.log("チャレンジステップなかみ");
      console.log(response.data.challengeStep);
    },
  },

  computed: {
    // ideaストアのideasを参照
    ...mapState({
      steps: (state) => state.step.steps,
      favSteps: (state) => state.step.favSteps,
      challengeSteps: (state) => state.step.challengeSteps,
    }),
    // // ideaストアのfilteredIdeas(絞り込み後のアイディア)を参照
    // ...mapGetters({
    //   filteredIdeas: "idea/filteredIdeas",
    // }),
    // // 表示したいデータの最初の値
    // listStart() {
    //   return 6 * (this.$store.state.paging.paginationNUmber - 1);
    // },
    // //　表示したデータを取得。1〜6、7〜12、13〜18...の6ごとのデータを取得
    // filtered() {
    //   let list = [];
    //   if (this.filteredIdeas) {
    //     list = this.filteredIdeas.concat();
    //   } else {
    //     list = this.ideas.concat();
    //   }
    //   if (this.length) {
    //     list = list.splice(this.listStart, this.length);
    //   }
    //   console.log("listの中身");
    //   console.log(list);
    //   return list;
    // },
  },

  watch: {
    $route: {
      async handler(to, from) {
        console.log(from);
        console.log("$routeが変わった");
        await this.fetchSteps(); // api通信開始メソッド実行
        console.log(to);
      },
      immediate: true, // 起動時にも実行
    },
  },
};
</script>