// import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  steps: [],
  childSteps: [],
  favSteps: [],
  challengeSteps: [],
  filterQuery: {
    category: "",
    favorite: "",
    searchTitle: "",
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

    if (!query.category && !query.favorite && !query.searchTitle) {
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
    if (query.favorite) {  // お気に入り順検索
      console.log(query.favorite)
      if (query.favorite === "high") { // 多い順に並び替え
        console.log("多い順絞り込み")
        data.sort(function (a, b) {
          if (a.favorites_count < b.favorites_count) return 1;
          if (a.favorites_count > b.favorites_count) return -1;
          return 0;
        });
      }
      if (query.favorite === "low") { 　// 少ない順に並び替え
        console.log("少ない順絞り込み")
        data.sort(function (a, b) {
          if (a.favorites_count < b.favorites_count) return -1;
          if (a.favorites_count > b.favorites_count) return 1;
          return 0;
        });
      }

      return data;
    }
    if (query.searchTitle) {
      // カテゴリー検索
      data = data.filter(function (step) {
        console.log("タイトル検索絞り込み済みSTEP")
        // 絞り込み中のタイトルの一部と合致したSTEPのみ配列に入れ直す。
        return step.title.indexOf(query.searchTitle) !== -1;
      });

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
  setChildSteps(state, childs) {
    state.childSteps = childs;
    console.log(state.childSteps);
  },
  setCategoryMenu(state, boolean) {
    state.categoryMenu = boolean;
  },
  setFavSteps(state, steps) {
    state.favSteps = steps;
  },
  setChallengeSteps(state, steps) {
    state.challengeSteps = steps;
  },

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
  // stateのchildSteps情報を更新
  async setChildSteps(context, childs) {
    context.commit('setChildSteps', childs)
  },
  // stateのcategoryMenu情報を更新
  async setCategoryMenu(context, boolean) {
    context.commit('setCategoryMenu', boolean)
  },
  // stateのstep情報を更新
  async setFavSteps(context, steps) {
    context.commit('setFavSteps', steps)
  },
  // stateのstep情報を更新
  async setChallengeSteps(context, steps) {
    context.commit('setChallengeSteps', steps)
  },

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}