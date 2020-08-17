<template>
  <div>
    <left-bar></left-bar>
    <right-bar :items="items"></right-bar>
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
import RightBar from './components/RightBar.vue'

import { mapState } from 'vuex'

export default Vue.extend({
  name: 'Root',
  components: { LeftBar, RightBar },
  data() {
    return {}
  },
  computed: mapState(['items']),
})
</script>
