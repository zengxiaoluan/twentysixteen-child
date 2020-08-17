<template>
  <v-container class="grey lighten-5">
    <v-text-field label="Another input"></v-text-field>
    <v-row>
      <v-col cols="4" sm="12" md="4">
        <left-bar></left-bar>
      </v-col>
      <v-col cols="8" sm="12" md="8">
        <right-bar :items="items"></right-bar>
      </v-col>
    </v-row>
  </v-container>
</template>

<style>
h1 {
  color: red !important;
}
.v-text-field__slot input {
  background: none;
  border: none;
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
