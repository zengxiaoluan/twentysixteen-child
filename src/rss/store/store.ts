import Vue from 'vue'
import Vuex from 'vuex'
import { CLEAR_ITEMS, LOADING } from './mutation-types'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    count: 0,
    items: [''],
    loading: false,
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
    [LOADING](state, v: boolean) {
      state.loading = v
    },
  },
})

store.commit('increment')

export default store
