import Vue from 'vue'
import VueRouter from 'vue-router'

// コンポーネントをインポートする
import Top from './components/Top.vue'
import StepList from './components/StepList.vue'
import Login from './components/Login.vue'
import Reset from "./components/Reset.vue";
import RegisterStep from "./components/RegisterStep.vue";
import RegisterChild from "./components/RegisterChild.vue";
import Mypage from './components/Mypage.vue';
import StepDetail from './components/StepDetail.vue';
import ChildStep from './components/ChildStep.vue';
import Profile from './components/Profile.vue';
import SystemError from './pages/errors/System.vue';

// ナビゲーションガードを使用するためstoreをインポート
import store from './store'

// VueRouterプラグインを使用し、<RouterView />コンポーネントを使用可能にする
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/top',
    component: Top // TOP画面表示
  },
  {
    path: '/login',
    component: Login,
    beforeEnter(to, from, next) {  // ログイン済みの場合は、ホーム画面へリダイレクト
      if (store.getters['auth/check']) {
        next('/step_list')
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
        next("/step_list");
      } else {
        next();
      }
    }
  },
  {
    path: "/step_list", // STEP登録画面へのパス
    component: StepList
  },
  {
    path: '/step_list/:id', // STEP詳細画面へのパス
    component: StepDetail,
    props: true
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
    path: '/register_child/step=:step_id/child', // 子STEP登録画面へのパス
    component: RegisterChild,
    beforeEnter(to, from, next) {
      if (store.getters["auth/check"]) {
        next();
      } else {
        next('/login'); // ログイン済みで無い場合は、ログイン画面へリダイレクト
      }
    }
  },
  {
    path: "/update_step", // STEP編集画面へのパス
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
    path: '/step_list/:id', // STEP詳細画面へのパス
    component: StepDetail,
    props: true
  },
  {
    path: '/step_list/step=:step_id/child', // 子STEP詳細画面へのパス
    component: ChildStep,
    props: true
  },
  {
    path: '/mypage',
    component: Mypage,
  },
  {
    path: "/profile", // STEP編集画面へのパス
    component: Profile,
    beforeEnter(to, from, next) {
      if (store.getters["auth/check"]) {
        next();
      } else {
        next('/login'); // ログイン済みで無い場合は、ログイン画面へリダイレクト
      }
    }
  },
  {
    path: '/500',
    component: SystemError
  }
]

// VueRouterインスタンス生成
const router = new VueRouter({
  mode: 'history', // 本来のURLの形にするため
  // 画面遷移後、スクロールバーをデフォルト値へ移動
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes
});

//app.jsでインポートするため、VueRouterインスタンスをエクスポートする
export default router