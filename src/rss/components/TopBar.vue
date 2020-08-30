<template>
  <v-row class="row">
    <v-col md="8">
      <v-text-field
        label="https://zengxiaoluan.com/feed/"
        v-model="feedUrl"
        @keyup="keyUpHandler"
      ></v-text-field>
    </v-col>

    <v-col>
      <v-btn large @click="add">Add</v-btn>
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
import RSSStorage from '../database/localstorage'

export default Vue.extend({
  name: 'top-bar',
  data() {
    return {
      feedUrl: 'https://www.zhangxinxu.com/wordpress/feed',
    }
  },
  methods: {
    keyUpHandler(event: KeyboardEvent) {
      if (event.code === 'Enter') {
        this.add()
      }
    },
    add() {
      RSSStorage.setFeedList(this.feedUrl)
      this.feedUrl = ''
    },
  },
})
</script>
