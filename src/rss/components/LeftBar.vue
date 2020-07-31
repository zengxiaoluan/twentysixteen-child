<template>
  <ul>
    <li v-for="item,index of subscribes" v-bind:key="item">{{item}}</li>
  </ul>
</template>

<style scoped></style>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  name: 'left-bar',
  data() {
    return {
      subscribes: [1, 2, 3, 4, 5],
    }
  },
  created() {
    const RSS_URL = `https://codepen.io/picks/feed/`

    fetch(RSS_URL)
      .then((response) => response.text())
      .then((str) => new window.DOMParser().parseFromString(str, 'text/xml'))
      .then((data) => {
        console.log(data)
        const items = data.querySelectorAll('item')
        let html = ``
        items.forEach((el) => {
          html += `
        <article>
          <img src="${
            el?.querySelector('link')?.innerHTML
          }/image/large.png" alt="">
          <h2>
            <a href="${
              el?.querySelector('link')?.innerHTML
            }" target="_blank" rel="noopener">
              ${el?.querySelector('title')?.innerHTML}
            </a>
          </h2>
        </article>
      `
        })
        document.body.insertAdjacentHTML('beforeend', html)
      })
  },
})
</script>