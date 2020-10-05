<template>
  <div>
    <div v-if="loading" class="v-application">
      <v-row justify="center" align="center">
        <v-progress-circular
          :size="70"
          :width="7"
          color="purple"
          indeterminate
        ></v-progress-circular>
      </v-row>
    </div>

    <div v-else v-for="(item, index) of items" :key="index">
      <a
        v-if="item"
        :href="item.link"
        target="_blank"
        style="margin-bottom: 1rem;"
      >
        <v-card class="mx-auto" margin-bottom="2rem">
          <v-card-title>{{ item.title }}</v-card-title>
          <v-card-text>
            <div>作者：{{ item.creator }}</div>
            <div class="text--primary" v-html="item.content"></div>
          </v-card-text>
        </v-card>
      </a>
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
