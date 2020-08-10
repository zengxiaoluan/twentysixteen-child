<template>
  <div>
    <ul>
      <li v-for="(item, index) of subscribes" v-bind:key="index">{{ item }}</li>
    </ul>
    <right-bar :items="itemsData"></right-bar>
  </div>
</template>

<style scoped></style>

<script lang="ts">
declare var ajaxurl: string
import Vue from 'vue'
import axios from 'axios'

import RightBar from './RightBar.vue'

export default Vue.extend({
  name: 'left-bar',
  components: { RightBar },

  data() {
    return {
      subscribes: [],
      itemsData: [],
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
        .then((res) => {
          console.log(res)
          let { data } = res
          if (data.success) {
            let xml = data.data
            let dom = new window.DOMParser().parseFromString(xml, 'text/xml')
            let title = dom.querySelector('channel > title')
            ;(this.subscribes as any).push(title?.innerHTML)

            const items = dom.querySelectorAll('item')

            items.forEach((el) => {
              // console.log(el)
              let title = el?.querySelector('title')?.innerHTML
              let link = el?.querySelector('link')?.innerHTML
              let description = el?.querySelector('description')?.innerHTML

              ;(this.itemsData as any).push({ title, link, description })
            })

            console.log(this.itemsData)
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
