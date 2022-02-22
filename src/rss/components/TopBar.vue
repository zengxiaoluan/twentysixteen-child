<template>
  <v-row class="row">
    <v-col md="8">
      <v-text-field label="https://zengxiaoluan.com/feed/" v-model="feedUrl" @keyup="keyUpHandler"></v-text-field>
    </v-col>

    <v-col>
      <v-btn large @click="add">Add</v-btn>
    </v-col>

    <v-col>
      <v-btn :loading="false" @click="emptyFeeds" large>Empty Feeds</v-btn>
    </v-col>
  </v-row>
</template>

<style scoped>
.row {
  align-items: center;
}
</style>

<script lang="ts">
import Vue from 'vue'
import { mapMutations, mapState } from 'vuex'
import RSSStorage from '../database/localstorage'
import { UPDATE_SUBSCRIBERS } from '../store/mutation-types'

let mutations = mapMutations([UPDATE_SUBSCRIBERS])
let state = mapState({
  feeds: (s: any) => s.subscribes,
})

export default Vue.extend({
  name: 'top-bar',

  data() {
    return {
      feedUrl: '',
    }
  },

  watch: {
    feeds() {
      this.feedUrl = this.feeds.length
        ? ''
        : 'https://www.zhangxinxu.com/wordpress/feed'
    },
  },

  computed: {
    ...state,
  },

  methods: {
    ...mutations,
    keyUpHandler(event: KeyboardEvent) {
      if (event.code === 'Enter') {
        this.add()
      }
    },
    add() {
      RSSStorage.setFeedList(this.feedUrl)
      this.feedUrl = ''
      this[UPDATE_SUBSCRIBERS]()
    },
    emptyFeeds() {
      RSSStorage.updateAllSubscribe([])
      this[UPDATE_SUBSCRIBERS]()
    },
  },
})
</script>
