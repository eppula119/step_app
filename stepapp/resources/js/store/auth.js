import { OK, CREATED, INTERNAL_SERVER_ERROR, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  user: null,  // ユーザー情報が入る
  apiStatus: null,  // API呼び出し成功か失敗か入る
  loginErrorMessages: null, // エラーメッセージが入る
  registerErrorMessages: null, // エラーメッセージが入る
  forgotErrorMessages: null, // パスワード変更エラーメッセージの保持
  resetErrorMessages: null // リセットパスワードエラーメッセージの保持
}

const getters = {
  check: state => !!state.user,  // ログインチェック
}

const mutations = {
  setUser(state, user) {
    state.user = user     // stateのユーザー情報を更新
  },
  setApiStatus(state, status) {
    state.apiStatus = status  // stateのapiStatusを更新
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages // stateのloginErrorMessagesを更新
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages // stateのregisterErrorMessagesを更新
  },
  setForgotErrorMessages(state, messages) { // パスワード変更エラーメッセージの更新
    state.forgotErrorMessages = messages;
  },
  setResetErrorMessages(state, messages) { // リセットパスワードエラーメッセージの更新
    state.resetErrorMessages = messages;
  }
}

const actions = {
  // 会員登録
  async register(context, data) {     // stateにユーザー登録したユーザー情報を更新
    context.commit('setApiStatus', null)
    console.log('POST送信します')
    console.log(data);
    const response = await axios.post('/api/register', data)
    if (response.status === CREATED) {
      // context.commit('setApiStatus', true)
      console.log('レスポンス成功！')
      context.commit('setUser', response.data)
      return false
    }
    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
      console.log(response.data);
    } else {
      context.commit('error/setCode', response.status, { root: true })
      console.log(response.data);
    }
  },
  // ログイン
  async login(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', data).catch(err => err.response || err)

    if (response.status === OK) { // 通信成功したらstateにログインしたユーザー情報を更新
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }
    context.commit('setApiStatus', false) // 通信失敗だったらfalse
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors) // バリデーションに引っかかった場合、エラーメッセージをセット
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  // ログアウト
  async logout(context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    if (response.status === OK) { // ログアウト成功後、stateのユーザー情報をnullに変更
      context.commit('setApiStatus', true)
      console.log('ユーザー情報初期化開始')
      context.commit('setUser', null)
      console.log('ユーザー情報初期化完了')
      return false
    }
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  // パスワード変更　
  async forgot(context, data) {
    context.commit("setApiStatus", null); // apiStatusのクリア
    console.log(data);
    const response = await axios.post("/api/forgot", data);

    if (response.status === CREATED) { // 通信成功の場合 201
      context.commit("setApiStatus", true); // apiStatus を true に更新
      return false;
    }
    context.commit("setApiStatus", false); // 422（バリデーションエラー）の場合,false に更新
    if (response.status === UNPROCESSABLE_ENTITY) { // 422（バリデーションエラー）の場合
      context.commit("setForgotErrorMessages", response.data.errors); // registerErrorMessages にエラーメッセージを登録
    }
    else { // 通信失敗のステータスがその他の場合
      context.commit("error/setCode", response.status, { root: true });
    }
  },
  // パスワードリセット
  async reset(context, data) {
    context.commit("setApiStatus", null); // apiStatusのクリア
    const response = await axios.post("/api/reset", data);

    if (response.status === OK) { // 通信成功の場合 200
      context.commit("setApiStatus", true); // apiStatus を true に更新
      context.commit("setUser", response.data); // user にデータを登録
      return false;
    }

    context.commit("setApiStatus", false); // apiStatus を false に更新
    if (response.status === UNPROCESSABLE_ENTITY) { // 422（バリデーションエラー）の場合
      context.commit("setResetErrorMessages", response.data.errors); // バリデーションエラーメッセージセット
    }
    else { // 通信失敗のステータスがその他の場合
      context.commit("error/setCode", response.status, { root: true });
    }
  },

  // ログインユーザーチェック
  async currentUser(context) {
    context.commit('setApiStatus', null)
    console.log('ユーザーチェック')
    const response = await axios.get('/api/user')
    const user = response.data || null
    console.log(user)
    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', user)
      return false
    }
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}