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
            <v-list-item-title
              v-html="item.title || item.url"
            ></v-list-item-title>
            <v-list-item-subtitle
              v-html="item.description"
            ></v-list-item-subtitle>
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
import axios from 'axios'
import Parser from 'rss-parser'
import RSSStorage from '../database/localstorage'

import RightBar from './RightBar.vue'
import { isFeedAddress } from '../util'
import { CLEAR_ITEMS } from '../store/mutations'
import { FeedAddress } from '../interface'

let rssParser = new Parser()

export default Vue.extend({
  name: 'left-bar',
  components: { RightBar },

  data() {
    return {
      subscribes: [] as FeedAddress[],
      item: '0',
    }
  },

  methods: {
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
            let dom = new window.DOMParser().parseFromString(xml, 'text/xml')
            let title = dom.querySelector('channel > title')

            const items = dom.querySelectorAll('item')
            let itemsData: any[] = []

            items.forEach((el) => {
              // console.log(el)
              let title = el?.querySelector('title')?.innerHTML
              let link = el?.querySelector('link')?.innerHTML
              let description = el?.querySelector('description')?.innerHTML

              itemsData.push({ title, link, description })
            })

            this.$store.commit(CLEAR_ITEMS)
            this.$store.commit('concatItems', { amount: itemsData })
          }
        })
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
    },
  },
  created() {
    const urls = [
      'https://www.zhangxinxu.com/wordpress/feed',
      'https://coolshell.cn/feed',
      'https://codepen.io/picks/feed/',
    ]

    let list = RSSStorage.getFeedList()
    for (const url of list) {
      if (isFeedAddress(url)) {
        let item: FeedAddress = {
          url,
          title: '',
          description: '',
        }
        this.subscribes.push(item)
      }
    }

    console.log(this.subscribes)
  },
})
</script>
