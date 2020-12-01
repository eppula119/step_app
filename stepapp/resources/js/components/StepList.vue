<template>
  <!--ーーーーーーーーーーーーーーーーーー STEP一覧画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-stepList">
    <div class="l-bg p-stepList">
      <div class="p-stepList__container">
        <Step v-for="step in filtered" :key="step.id" :item="step" />
      </div>

      <!--ーーーーーーーーーーーーーーーーーー ページネーション ーーーーーーーーーーーーーーーーーー-->
      <ul class="c-pagenation p-stepListPage">
        <Pagination :items="filteredSteps"></Pagination>
      </ul>
    </div>
  </main>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";
import Step from "../components/Step.vue";
import { mapState, mapGetters } from "vuex";
import Pagination from "../components/Pagination.vue";

export default {
  components: {
    Step,
    Pagination
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data() {
    return {
      currentPage: 0,
      lastPage: 0,
      length: 3
    };
  },
  methods: {
    // 全てのアイディアを取得
    async fetchSteps() {
      const response = await axios.get("/api/step_list");
      console.log(response.data);
      //　レスポンスエラーの場合エラーstateにstatusをセット
      if (response.status !== OK) {
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      // 通信成功時、stepストアにアイディア全てセット
      this.$store.dispatch("step/setSteps", response.data);
    }
  },
  computed: {
    // stepストアのstepsを参照
    ...mapState({
      steps: state => state.step.steps
    }),
    // stepストアのfilteredSteps(絞り込み後のstep)を参照
    ...mapGetters({
      filteredSteps: "step/filteredSteps"
    }),
    // 表示したいデータの最初の値
    listStart() {
      return 3 * (this.$store.state.paging.paginationNumber - 1);
    },
    //　表示したデータを取得。1〜6、7〜12、13〜18...の6ごとのデータを取得
    filtered() {
      let list = [];
      if (this.filteredSteps) {
        list = this.filteredSteps.concat();
      } else {
        list = this.steps.concat();
      }

      if (this.length) {
        list = list.splice(this.listStart, this.length);
        console.log(list);
      }
      console.log("listの中身");
      console.log(list);
      return list;
    }
  },
  watch: {
    $route: {
      async handler(to, from) {
        console.log(from);
        console.log("$routeが変わった");
        await this.fetchSteps(); // api通信開始メソッド実行
        console.log(to);
      },
      immediate: true // 起動時にも実行
    }
  }
};
</script>