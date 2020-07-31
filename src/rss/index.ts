import Vue from 'vue'
import Root from './Root.vue'

new Vue({
  render: h => h(Root),
  created() {
    console.log('dddddcd')
  },
}).$mount('#app')
