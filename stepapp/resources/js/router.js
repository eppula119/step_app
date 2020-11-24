import Vue from 'vue'
import VueRouter from 'vue-router'

// コンポーネントをインポートする
import StepList from './components/StepList.vue'
import Login from './components/Login.vue'
import Reset from "./components/Reset.vue";
import RegisterStep from "./components/RegisterStep.vue";
// import Mypage from './components/Mypage.vue';
import StepDetail from './components/StepDetail.vue';
import SystemError from './pages/errors/System.vue'

// ナビゲーションガードを使用するためstoreをインポート
import store from './store'

// VueRouterプラグインを使用し、<RouterView />コンポーネントを使用可能にする
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: StepList // Step一覧画面表示
  },
  {
    path: '/login',
    component: Login,
    beforeEnter(to, from, next) {  // ログイン済みの場合は、ホーム画面へリダイレクト
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: "/reset",
    component: Reset,
    beforeEnter(to, from, next) {
      if (store.getters["auth/check"]) {
        next("/");
      } else {
        next();
      }
    }
  },
  {
    path: "/register_step", // STEP登録画面へのパス
    component: RegisterStep,
    beforeEnter(to, from, next) {
      if (store.getters["auth/check"]) {
        next();
      } else {
        next('/login'); // ログイン済みで無い場合は、ログイン画面へリダイレクト
      }
    }
  },
  {
    path: '/steps/:id',
    component: StepDetail,
    props: true
  },
  {
    path: '/500',
    component: SystemError
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history', // 本来のURLの形にする
  routes
})

//app.jsでインポートするため、VueRouterインスタンスをエクスポートする
export default router