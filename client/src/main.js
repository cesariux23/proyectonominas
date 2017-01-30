// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import store from './vuex/store'

Vue.prototype.$baseURL = 'http://localhost:3030'
axios.defaults.baseURL = Vue.prototype.$baseURL
Vue.prototype.$http = axios

/* eslint-disable no-new */
new Vue({
  router,
  store,
  el: '#app',
  template: '<App/>',
  components: { App }
})
