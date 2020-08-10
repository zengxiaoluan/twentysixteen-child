<template>
  <div>
    <h1>{{ title }}</h1>
    <left-bar></left-bar>
    <!-- <right-bar></right-bar> -->
  </div>
</template>

<style scoped>
h1 {
  background: red;
}
</style>

<script lang="ts">
import Vue from 'vue'
import LeftBar from './components/LeftBar.vue'
// import RightBar from './components/RightBar.vue'

export default Vue.extend({
  name: 'Root',
  components: { LeftBar },
  data() {
    return {
      title: '小阁 rss 阅读器',
      subscribes: ['1', 2, 3, 4],
    }
  },
  created() {},
})
</script>
