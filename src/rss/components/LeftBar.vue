<template>
  <v-app>
    <v-list
      :rounded="false"
      :disabled="false"
      :dense="false"
      :two-line="false"
      :three-line="false"
      :shaped="false"
      :flat="false"
      :subheader="false"
      :sub-group="false"
      :nav="false"
      :avatar="false"
    >
      <v-list-item-group v-model="item" color="primary">
        <v-list-item
          @click="click(item.url, i)"
          v-for="(item, i) in subscribes"
          :key="i"
          :inactive="false"
          @contextmenu.prevent="contextmenu($event, i)"
        >
          <v-list-item-content>
            <v-list-item-title v-html="item.title || item.url" :title="item.title"></v-list-item-title>
            <v-list-item-subtitle v-html="item.description" :title="item.description"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <div>
      <v-list v-show="showMenu" id="right-menu" class="menu">
        <v-list-item-group color="primary">
          <v-list-item :key="0">
            <v-list-item-title @click="delFeed">删除</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </div>
  </v-app>
</template>

<style scoped>
.menu {
  position: fixed;
}
</style>

<script lang="ts">
declare var ajaxurl: string

import Vue from 'vue'
import { mapMutations, mapState } from 'vuex'

import axios from 'axios'
import Parser, { Item } from 'rss-parser'
import RSSStorage from '../database/localstorage'

import RightBar from './RightBar.vue'
import { isFeedAddress } from '../util'
import {
  CLEAR_ITEMS,
  DELETE_SUBSCRIBER,
  LOADING,
  UPDATE_ERROR_MSG,
  UPDATE_SUBSCRIBERS,
} from '../store/mutation-types'
import { FeedAddress } from '../interface'

let rssParser = new Parser()

let methods = mapMutations([
  CLEAR_ITEMS,
  LOADING,
  UPDATE_SUBSCRIBERS,
  UPDATE_ERROR_MSG,
  DELETE_SUBSCRIBER,
])

let computed = mapState({
  subscribes: (state: any) => state.subscribes,
})

export default Vue.extend({
  name: 'left-bar',
  components: { RightBar },

  data() {
    return {
      showMenu: false,
      item: '0',
      clickIndex: -1,
      delIndex: -1,
    }
  },

  computed: {
    ...computed,
  },

  methods: {
    ...methods,
    delFeed() {
      this[DELETE_SUBSCRIBER](this.delIndex)
      this.showMenu = false
      RSSStorage.updateAllSubscribe(this.subscribes)
    },
    contextmenu(event: any, i: number) {
      let { clientX, clientY, screenX, screenY } = event
      this.showMenu = true

      let menu: HTMLElement = document.querySelector(
        '#right-menu'
      ) as HTMLElement

      this.delIndex = i

      menu.style.left = clientX + 'px'
      menu.style.top = clientY + 'px'

      setTimeout(() => {
        this.showMenu = false
      }, 5 * 1000)
    },
    fetchData(feedUrl: string) {
      this[UPDATE_ERROR_MSG]('')

      let action = 'get_rss_data'

      axios
        .get(ajaxurl, {
          params: {
            action,
            feedUrl,
          },
        })
        .then(async (res) => {
          let { data } = res
          let { success, data: xml } = data
          if (success) {
            xml = xml.replace('\ufeff', '')
            let feeds = await rssParser.parseString(xml)
            this.updateSubscribes(feeds)

            console.log(feeds)

            let itemsData: Item[] = feeds.items || []

            this.$store.commit(CLEAR_ITEMS)
            this.$store.commit('concatItems', {
              amount: itemsData.slice(0, 20),
            })
          } else {
            this[CLEAR_ITEMS]()
            this[UPDATE_ERROR_MSG](xml)
          }

          this[LOADING](false)
        })

      this[LOADING](true)
    },
    click(url: string, index: number) {
      this.fetchData(url)
      this.clickIndex = index
    },
    updateSubscribes(feed: any) {
      let { feedUrl, link, title, description } = feed

      feedUrl = feedUrl || link
      let index = 0

      for (const item of this.subscribes) {
        if (index === this.clickIndex) {
          item.title = title
          item.description = description
        }

        index++
      }

      RSSStorage.updateAllSubscribe(this.subscribes)
    },
  },
  created() {
    this[UPDATE_SUBSCRIBERS]()

    console.log(this.subscribes)
  },
})
</script>
