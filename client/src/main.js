// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import store from './vuex/store'
import socketIOClient from 'socket.io-client'
import sailsIOClient from 'sails.io.js'
import vueSails from 'vue-sails'

// Stylesheets
import './assets/scss/main.scss'
import 'font-awesome/css/font-awesome.css'

const io = sailsIOClient(socketIOClient)

// Additional Sails.io.js configuration
io.sails.url = 'http://localhost:1337'
// io.sails.environment = process.env.NODE_ENV || 'development';

// Enable the plugin globally
Vue.use(vueSails, io)

Vue.prototype.$baseURL = 'http://localhost:1337'
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
