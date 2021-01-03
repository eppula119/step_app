

const state = {
  step_id: "",
  child_id: "",
  modalFlg: false,  // モーダル表示・非表示
  deleteModalFlg: false,  // 削除モーダル表示・非表示
}

const mutations = {
  setStepId(state, id) {
    state.step_id = id;  // stateのstep_idを更新
  },
  setChildId(state, id) {
    state.child_id = id;  // stateのchild_idを更新
  },
  setModalVal(state, modalVal) {
    state.modalFlg = modalVal;  // stateのmodalFlgを更新
  },
  setDeleteModal(state, deleteModal) {
    state.deleteModalFlg = deleteModal;  // stateのdeleteMoldalFlgを更新
  }
}

const actions = {
  async setStepId(context, id) {      // STEPのidを更新
    context.commit('setStepId', id)
  },
  async setChildId(context, id) {      // 子STEPのidを更新
    context.commit('setChildId', id)
  },
  async setModalVal(context, modalVal) {      // モーダルFlgを更新
    context.commit('setModalVal', modalVal)
  },
  async setDeleteModal(context, reviewModal) {      // 削除モーダルFlgを更新
    context.commit('setDeleteModal', reviewModal)
  }
}


export default {
  namespaced: true,
  state,
  mutations,
  actions
}