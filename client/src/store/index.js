import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import moment from 'moment'

import empleadosModule from './modules/empleados/index'
Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    empleados: empleadosModule
  },

  state: {
    catalogos: {
      tipo_nomina: []
    },
    meses: moment.months(),
    token: null,
    user: {}
  },
  actions: {
    // Autenticacion
    login ({ state, commit }, creds) {
      return axios.post('/auth/login', creds).then((response) => {
        commit('setToken', response.data.jwt)
        commit('setUser', response.data.user)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.jwt
        return Promise.resolve()
      }
      , (error) => {
        return Promise.reject(error.response)
      })
    },
    logout ({ commit }) {
      commit('clearToken')
      commit('clearUser')
      delete axios.defaults.headers.common['Authorization']
    },
    // catalogos
    fetchCatalogos: ({ commit }) => {
      axios.get('/catalogos').then((response) => {
        commit('setCatalogos', response.data)
      }, (err) => {
        console.log(err)
      })
    },
    // Adscripciones
    saveAdscripcion: ({ dispatch }, adscripcion) => {
      return axios.post('/adscripcion', adscripcion).then((response) => {
        dispatch('fetchCatalogos')
        return Promise.resolve()
      }, (error) => {
        return Promise.reject(error.response)
      })
    },
    // movimientos del personal
    saveMovimiento: ({ dispatch }, data) => {
      return axios.post('/empleado/' + data.id + '/movimiento', data).then((response) => {
        return Promise.resolve()
      }, (error) => {
        return Promise.reject(error.response)
      })
    },
    // nominas
    saveNomina: (contex, nomina) => {
      return axios.post('/nomina', nomina).then((response) => {
        return Promise.resolve(response.data)
      }, (error) => {
        return Promise.reject(error.response)
      })
    },
    getNomina: (contex, id) => {
      return axios.get('/nomina/' + id).then((response) => {
        return Promise.resolve(response.data)
      }, (error) => {
        return Promise.reject(error.response)
      })
    },
    fetchNominas: (contex) => {
      return axios.get('/nomina').then((response) => {
        return Promise.resolve(response.data)
      }, (error) => {
        return Promise.reject(error.response)
      })
    }
  },
  mutations: {
    // authentication
    setToken (state, token) {
      state.token = token
      localStorage.setItem('token', token)
    },
    clearToken (state) {
      state.token = null
      localStorage.removeItem('token')
    },
    setUser (state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
    },
    clearUser (state) {
      state.user = {}
      localStorage.removeItem('user')
    },
    setCatalogos: (state, catalogos) => {
      state.catalogos = catalogos
    }
  },
  getters: {
    isAuthenticated (state) {
      return state.token != null
    },
    user: state => {
      return state.user
    }
  }
})

export default store
