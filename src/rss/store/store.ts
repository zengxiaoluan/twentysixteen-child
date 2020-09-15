import Vue from 'vue'
import Vuex from 'vuex'
import { CLEAR_ITEMS, LOADING, UPDATE_SUBSCRIBERS } from './mutation-types'
import RSSStorage from '../database/localstorage'
import { FeedAddress } from '../interface'
import { isFeedAddress } from '../util'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    count: 0,
    items: [''],
    loading: false,
    subscribes: [] as FeedAddress[],
  },
  mutations: {
    concatItems(state, payload) {
      state.items = [...state.items, ...payload.amount]
    },
    [CLEAR_ITEMS](state) {
      state.items.length = 0
    },
    [LOADING](state, v: boolean) {
      state.loading = v
    },
    [UPDATE_SUBSCRIBERS](state) {
      state.subscribes = []
      let list = RSSStorage.getFeedList() as FeedAddress[]

      for (const item of list) {
        if (isFeedAddress(item.url)) {
          state.subscribes.push({ ...item })
        }
      }
    },
  },
})

export default store
