import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
// import idea from './idea'
// import paging from './paging'
// import message from './message'
// import modal from './modal'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error
    // idea,
    // paging,
    // message,
    // modal
  }
})

export default store