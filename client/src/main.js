// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import store from './store'
import Buefy from 'buefy'

// Stylesheets
import './assets/scss/main.scss'
import 'font-awesome/css/font-awesome.css'
import 'buefy/lib/buefy.css'

Vue.use(Buefy, {
  defaultIconPack: 'fa'
})

Vue.prototype.$baseURL = 'http://localhost:8001'
axios.defaults.baseURL = Vue.prototype.$baseURL
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
Vue.prototype.$http = axios

/* eslint-disable no-new */
new Vue({
  router,
  store,
  el: '#app',
  template: '<App/>',
  components: { App }
})
