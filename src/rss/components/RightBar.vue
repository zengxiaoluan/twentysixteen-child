<template>
  <div class="xg-items-container">
    <div v-if="loading" class="v-application">
      <v-row justify="center" align="center">
        <v-progress-circular :size="70" :width="7" color="purple" indeterminate></v-progress-circular>
      </v-row>
    </div>

    <div v-else v-for="(item, index) of items" :key="index">
      <a v-if="item" :href="item.link" target="_blank" style="margin-bottom: 1rem;">
        <v-card class="mx-auto" margin-bottom="2rem">
          <v-card-title>{{ item.title }}</v-card-title>
          <v-card-text>
            <div v-if="item.creator">作者：{{ item.creator }}</div>
            <iframe :src="src(item.content)" width="100%" height="auto" frameborder="0"></iframe>
          </v-card-text>
        </v-card>
      </a>
    </div>

    <v-alert v-if="errorMessage" :dismissible="true" type="success">{{ errorMessage }}</v-alert>
  </div>
</template>

<style scoped>
.xg-items-container {
  height: 600px;
  overflow: scroll;
}
</style>

<script lang="ts">
import Vue from 'vue'
import { mapState } from 'vuex'

let computed = mapState({
  loading: (state: any) => state.loading,
  errorMessage: (state: any) => state.errorMessage,
})

export default Vue.extend({
  name: 'right-bar',
  props: ['items'],
  methods: {
    src(content: string) {
      console.log(content)
      let style = '<style>img{width:100%;height:auto}</style>'
      return 'data:text/html;charset=utf-8,' + content + style
    },
  },
  computed: {
    ...computed,
  },
})
</script>
