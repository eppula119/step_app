<template>
  <paginate
    v-model="page"
    :page-count="paginationNumber"
    :page-range="3"
    :margin-pages="0"
    :prev-text="'＜'"
    :next-text="'＞'"
    :container-class="'pagination'"
    :page-class="'c-pagenation__item'"
  >></paginate>
</template>

<script>
import Vue from "vue";
import Paginate from "vuejs-paginate";
import { mapState } from "vuex";

Vue.component("paginate", Paginate);

export default {
  props: {
    items: {
      required: false,
      default: []
    }
  },
  data() {
    return {
      length: 3 // 1ページに表示するアイディアの数
    };
  },
  methods: {
    // clickCallback(pageNum) {
    //   this.page = pageNum; // pageNumはpagerの何番目をclickしたかを取得
    //   // console.log("dispatchページネーション遷移");
    //   // this.$store.dispatch("paging/setPageNum", pageNum); // 何番目をclickしたかをstoreの値にset
    // }
  },
  computed: {
    // 全ページ数
    paginationNumber() {
      return this.items.length / 3;
    },
    page: {
      get() {
        return this.$store.state.paging.paginationNumber; // pageストアの現在のページ番号取得
      },
      set(pageNum) {
        this.$store.dispatch("paging/setPageNum", pageNum); // pageストアに移動先のページ番号をセット
      }
    }
  }
};
</script>