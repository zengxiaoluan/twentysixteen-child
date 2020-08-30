import Vue from 'vue'
import Vuex from 'vuex'
import { CLEAR_ITEMS } from './mutations'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    count: 0,
    items: [''],
  },
  mutations: {
    increment(state) {
      state.count++
    },
    concatItems(state, payload) {
      state.items = [...state.items, ...payload.amount]
    },
    [CLEAR_ITEMS](state) {
      state.items.length = 0
    },
  },
})

store.commit('increment')

export default store
