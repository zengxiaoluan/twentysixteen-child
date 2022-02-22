// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
  theme: {
    light: true,
    themes: {
      light: {
        primary: '#cddc39',
        secondary: '#795548',
        accent: '#ffc107',
        error: '#ff5722',
        warning: '#ff9800',
        info: '#4caf50',
        success: '#2196f3',
      },
      dark: {},
    },
  },
}

export default new Vuetify(opts)
