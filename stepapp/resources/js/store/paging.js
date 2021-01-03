

const state = {
  paginationNumber: 1,  // 現在のページ
  stepList: true,
  top: false
}

const mutations = {
  setPageNum(state, pageNum) {
    state.paginationNumber = pageNum;  // stateの現在ページを更新
  },
  changeStepList(state, boolean) {
    state.stepList = boolean;  // stateのstep一覧ページか更新
  },
  changeTop(state, boolean) {
    state.top = boolean;  // stateのTOPページか更新
  }
}

const actions = {
  async setPageNum(context, pageNum) {      // ページ情報を更新
    context.commit('setPageNum', pageNum)
  },
  async changeStepList(context, boolean) {      // step一覧ページか更新
    context.commit('changeStepList', boolean)
  },
  async changeTop(context, boolean) {      // TOPページか更新
    context.commit('changeTop', boolean)
  }
}


export default {
  namespaced: true,
  state,
  mutations,
  actions
}