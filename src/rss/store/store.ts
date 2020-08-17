import Vue from 'vue'
import Vuex from 'vuex'

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
      console.log(state, payload)
      state.items = [...state.items, ...payload.amount]
    },
  },
})

store.commit('increment')

export default store
