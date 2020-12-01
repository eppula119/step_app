// import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  steps: [],
  filterQuery: {
    category: "",
    price: "",
    created_at: ""
  }, // 検索パラメータ
  searchFlg: false,
  categoryMenu: false,
  step_id: "",

}

const getters = {
  // カテゴリー検索後のアイディア全て
  filteredSteps(state) {
    let data = state.steps;
    let query = state.filterQuery;

    if (!query.category && !query.price && !query.created_at) {
      console.log("アイディアすべて返す")
      return data;
    }
    if (query.category) {
      // カテゴリー検索
      data = data.filter(function (step) {
        console.log("カテゴリー絞り込み済みアイディア")
        // 絞り込み中のカテゴリー名と合致したSTEPのみ配列に入れ直す。
        return step.category.name.indexOf(query.category) !== -1;
      });

    }
    if (query.created_at || query.price) {
      console.log(query.created_at)
      if (query.price === "high") {
        console.log("高い順絞り込み")
        data.sort(function (a, b) {
          if (a.price < b.price) return 1;
          if (a.price > b.price) return -1;
          return 0;
        });
      }
      if (query.price === "low") {
        console.log("低い順絞り込み")
        data.sort(function (a, b) {
          if (a.price < b.price) return -1;
          if (a.price > b.price) return 1;
          return 0;
        });
      }
      if (query.created_at === "new") {  // ここから書くところから
        console.log("新しい順絞り込み")
        data.sort(function (a, b) {
          if (a.created_at < b.created_at) return 1;
          if (a.created_at > b.created_at) return -1;
          return 0;
        });
      }
      if (query.created_at === "old") {  // ここから書くところから
        console.log("古い順絞り込み")
        data.sort(function (a, b) {
          if (a.created_at < b.created_at) return -1;
          if (a.created_at > b.created_at) return 1;
          return 0;
        });
      }
      return data;
    }


    return data;
  },
}

const mutations = {

  setStepId(state, step_id) {
    state.step_id = step_id;
  },
  setFilterQuery(state, filterQuery) {
    state.filterQuery = filterQuery;
  },

  setSteps(state, steps) {
    state.steps = steps;
    console.log(state.steps);
  },
  setCategoryMenu(state, boolean) {
    state.categoryMenu = boolean;
  }

}

const actions = {

  // stateのstep_idを更新
  async setStepId(context, step_id) {
    context.commit('setStepId', step_id)
  },
  // カテゴリー名絞り込みメソッド呼び出し
  async setFilterQuery(context, filterQuery) {
    context.commit('setFilterQuery', filterQuery)
  },
  // stateのstep情報を更新
  async setSteps(context, steps) {
    context.commit('setSteps', steps)
  },
  // stateのcategoryMenu情報を更新
  async setCategoryMenu(context, boolean) {
    context.commit('setCategoryMenu', boolean)
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}