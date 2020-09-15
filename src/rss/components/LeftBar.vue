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
        >
          <v-list-item-content>
            <v-list-item-title v-html="item.title || item.url"></v-list-item-title>
            <v-list-item-subtitle v-html="item.description"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-app>
</template>

<style scoped></style>

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
  LOADING,
  UPDATE_SUBSCRIBERS,
} from '../store/mutation-types'
import { FeedAddress } from '../interface'

let rssParser = new Parser()

let methods = mapMutations([CLEAR_ITEMS, LOADING, UPDATE_SUBSCRIBERS])
let computed = mapState({
  subscribes: (state: any) => state.subscribes,
})

console.log(computed, 'mapState')

export default Vue.extend({
  name: 'left-bar',
  components: { RightBar },

  data() {
    return {
      item: '0',
    }
  },

  computed: {
    ...computed,
  },

  methods: {
    ...methods,
    fetchData(feedUrl: string) {
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
          if (data.success && data.data) {
            let xml = data.data
            xml = xml.replace('\ufeff', '')
            let feeds = await rssParser.parseString(xml)
            this.updateSubscribes(feeds)

            console.log(feeds)

            let itemsData: Item[] | undefined = feeds.items

            this.$store.commit(CLEAR_ITEMS)
            this.$store.commit('concatItems', { amount: itemsData })
            this[LOADING](false)
          }
        })

      this[LOADING](true)
    },
    click(url: string, index: number) {
      this.fetchData(url)
    },
    updateSubscribes(feed: any) {
      let { feedUrl, title, description } = feed

      for (const item of this.subscribes) {
        if (item.url.replace(/\//g, '') === feedUrl.replace(/\//g, '')) {
          item.title = title
          item.description = description
        }
      }

      console.log(this.subscribes)
      RSSStorage.updateAllSubscribe(this.subscribes)
    },
  },
  created() {
    this[UPDATE_SUBSCRIBERS]()

    console.log(this.subscribes)
  },
})
</script>
