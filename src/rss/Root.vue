<template>
  <v-card class="mx-auto" tile>
    <v-container class="grey lighten-5">
      <top-bar></top-bar>
      <v-row>
        <v-col sm="12" md="4">
          <left-bar></left-bar>
        </v-col>
        <v-col sm="12" md="8">
          <right-bar :items="items"></right-bar>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<style>
.v-text-field__slot input {
  background: none;
  border: none;
}
</style>

<script lang="ts">
import Vue from 'vue'
import LeftBar from './components/LeftBar.vue'
import RightBar from './components/RightBar.vue'
import TopBar from './components/TopBar.vue'

import { mapState } from 'vuex'

let computed = mapState(['items'])

export default Vue.extend({
  name: 'Root',
  components: { LeftBar, RightBar, TopBar },
  data() {
    return {}
  },
  computed: {
    ...computed,
  },
})
</script>
