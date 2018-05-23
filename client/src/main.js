// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import Buefy from 'buefy'
import http from '@/api'

// Stylesheets
import './assets/scss/main.scss'
import 'font-awesome/css/font-awesome.css'
import 'buefy/lib/buefy.css'

Vue.use(Buefy, {
  defaultIconPack: 'fa'
})

Vue.prototype.$http = http

/* eslint-disable no-new */
new Vue({
  router,
  store,
  el: '#app',
  template: '<App/>',
  components: { App }
})
