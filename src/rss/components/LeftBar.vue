<template>
  <v-app>
    <v-card class="mx-auto" max-width="400" tile>
      <v-list
        :rounded="true"
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
        <v-list-item v-for="(item, i) in subscribes" :key="i" :inactive="true">
          <v-list-item-content>
            <v-list-item-title v-html="item"></v-list-item-title>
            <v-list-item-subtitle v-html="item"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-card>
  </v-app>
</template>

<style scoped></style>

<script lang="ts">
declare var ajaxurl: string
import Vue from 'vue'
import axios from 'axios'
import Parser from 'rss-parser'

import RightBar from './RightBar.vue'

let rssParser = new Parser()

export default Vue.extend({
  name: 'left-bar',
  components: { RightBar },

  data() {
    return {
      subscribes: [],
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
            console.log(feeds)
            let dom = new window.DOMParser().parseFromString(xml, 'text/xml')
            let title = dom.querySelector('channel > title')
            ;(this.subscribes as any).push(title?.innerHTML)

            const items = dom.querySelectorAll('item')
            let itemsData: any[] = []

            items.forEach((el) => {
              // console.log(el)
              let title = el?.querySelector('title')?.innerHTML
              let link = el?.querySelector('link')?.innerHTML
              let description = el?.querySelector('description')?.innerHTML

              itemsData.push({ title, link, description })
            })

            this.$store.commit('concatItems', { amount: itemsData })
          }
        })
    },
  },
  created() {
    const urls = [
      'https://www.zhangxinxu.com/wordpress/feed',
      'https://coolshell.cn/feed',
      'https://codepen.io/picks/feed/',
    ]

    for (const url of urls) {
      this.fetchData(url)
    }
  },
})
</script>
