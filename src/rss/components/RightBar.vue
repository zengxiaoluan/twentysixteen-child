<template>
  <div>
    <div v-for="(item, index) of items" :key="index">
      <h3>
        <a :href="item.link" target="_blank">
          {{ item.title }}
        </a>
      </h3>
    </div>
  </div>
</template>

<style scoped></style>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  name: 'right-bar',
  props: ['items'],
  created() {
    console.log(this.items)
    console.log('ccccccccc')
  },
  updated() {
    console.log('dddddddddddd', this.items)
  },
})
</script>
