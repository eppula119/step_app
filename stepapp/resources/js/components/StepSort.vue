<template>
  <div class="p-sort" v-show="stepList">
    <p class="p-categorySearch" v-on:click.stop="categoryShow()">
      <i class="far fa-list-alt p-categorySearch__icon"></i>カテゴリーから探す
    </p>
    <div class="p-category" v-bind:class="{'p-category--active':categoryMenu}">
      <ul class="p-category__items">
        <li class="p-categoryItem">カテゴリー</li>
        <label class="p-categoryItem" v-for=" (category, i) in this.categorys" :key="i">
          <input
            type="radio"
            class="p-categoryItem__link"
            :value="category.name"
            v-model="filterQuery.category"
            @change="handleChangeQuery"
          />
          {{ category.name }}
        </label>
      </ul>
    </div>

    <div class="p-favSort">
      <form method="post" action="#" class="p-sortForm">
        <select name="お気に入り" class="p-sortForm__select">
          <option value="1" class="p-selectItem">お気に入り多い順</option>
          <option value="2" class="p-selectItem">お気に入り少ない順</option>
        </select>
        <input type="submit" class="p-searchBtn" placeholder="検索" />
      </form>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      categorys: {},
      // 絞り込み中のカテゴリー
      filterQuery: {
        category: "",
        favorite: ""
      }
    };
  },
  created: function() {
    var self = this;
    var url = "/api/category/search";
    axios.post(url).then(function(response) {
      // カテゴリーモデルからデータを全て取得
      self.categorys = response.data["category"];
    });
  },
  mounted() {
    // stepストアの絞り込みメソッドを呼び出す
    this.$store.dispatch("step/setFilterQuery", this.filterQuery);
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      stepList: state => state.paging.stepList,
      categoryMenu: state => state.step.categoryMenu
    }),
    ...mapGetters({
      filteredSteps: "step/filteredSteps" //ログインしているかチェック
    })
  },
  methods: {
    // stepストアの絞り込みメソッドを呼び出す
    handleChangeQuery() {
      console.log("フィルタークエリ発動");
      this.$store.dispatch("step/setFilterQuery", this.filterQuery);
    },
    categoryShow() {
      console.log("カテゴリーオープン");
      this.$store.dispatch("step/setCategoryMenu", true);
    }
  },
  watch: {
    // 絞り込み後、現在ページを１ページ目に戻す
    "filterQuery.category": function() {
      this.$store.dispatch("paging/setPageNum", 1);
    },
    "filterQuery.favorite": function() {
      this.$store.dispatch("paging/setPageNum", 1);
    }
  }
};
</script>