

const state = {
  paginationNumber: 1,  // 現在のページ
  stepList: true
}

const mutations = {
  setPageNum(state, pageNum) {
    state.paginationNumber = pageNum;  // stateの現在ページを更新
  },
  changeStepList(state, boolean) {
    state.stepList = boolean;  // stateのstep一覧ページか更新
  }
}

const actions = {
  async setPageNum(context, pageNum) {      // ページ情報を更新
    context.commit('setPageNum', pageNum)
  },
  async changeStepList(context, boolean) {      // step一覧ページか更新
    context.commit('changeStepList', boolean)
  }
}


export default {
  namespaced: true,
  state,
  mutations,
  actions
}