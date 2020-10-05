<template>
  <div>
    <div v-if="loading" class="v-application">
      <v-row justify="center" align="center">
        <v-progress-circular :size="70" :width="7" color="purple" indeterminate></v-progress-circular>
      </v-row>
    </div>

    <div v-else v-for="(item, index) of items" :key="index">
      <h3>
        <a :href="item.link" target="_blank">{{ item.title }}</a>
      </h3>
    </div>
  </div>
</template>

<style scoped></style>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'


let computed = mapState({ loading: (state: any) => state.loading })

export default Vue.extend({
  name: 'right-bar',
  props: ['items'],
  computed: {
    ...computed,
  },
})
</script>
