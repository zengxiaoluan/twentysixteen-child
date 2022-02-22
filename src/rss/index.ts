import Vue from 'vue'
import store from './store/store'
import Root from './Root.vue'
import vuetify from './plugins/vuetify'

let vm = new Vue({
  store,
  vuetify,
  render: (h) => h(Root),
  created() {},
})

vm.$mount('#app')
