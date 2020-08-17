import Vue from 'vue'
import store from './store/store'
import Root from './Root.vue'

let vm = new Vue({
  store,
  render: (h) => h(Root),
  created() {},
})

vm.$mount('#app')
