import Vue from 'vue'
import Vuex from 'vuex'
import api from '@/api'
import moment from 'moment'
import createPersistedState from 'vuex-persistedstate'
import createMutationsSharer from 'vuex-shared-mutations'

import EmpleadosModule from './modules/empleados/index'
import NominasModule from './modules/nominas/index'
import DesgloseNominaModule from './modules/nominas/desglose/index'

Vue.use(Vuex)
moment.locale('es')

const store = new Vuex.Store({
  plugins: [
    createPersistedState(),
    createMutationsSharer({ predicate: ['setToken', 'clearToken'] })
  ],
  modules: {
    empleados: EmpleadosModule,
    nominas: NominasModule,
    desgloseNomina: DesgloseNominaModule
  },

  state: {
    catalogos: {
      tipo_nomina: []
    },
    meses: moment.months(),
    token: null,
    user: {},
    rootPath: '/empleados',
    nextRoute: null
  },
  actions: {
    // Autenticacion
    login ({ commit }, creds) {
      return api.post('/auth/login', creds).then((response) => {
        commit('setToken', response.data.jwt)
        commit('setUser', response.data.user)
        return Promise.resolve()
      }
      , (error) => {
        return Promise.reject(error.response)
      })
    },
    logout ({ commit }) {
      commit('clearToken')
      commit('clearUser')
    },
    nextRoute ({ commit }, route) {
      commit('nextRoute', route)
    },
    // catalogos
    fetchCatalogos: ({ commit }) => {
      api.get('/catalogos').then((response) => {
        commit('setCatalogos', response.data)
      }, (err) => {
        console.log(err)
      })
    },
    // Adscripciones
    saveAdscripcion: ({ dispatch }, adscripcion) => {
      return api.post('/adscripcion', adscripcion).then((response) => {
        dispatch('fetchCatalogos')
        return Promise.resolve()
      }, (error) => {
        return Promise.reject(error.response)
      })
    },
    // movimientos del personal
    saveMovimiento: ({ dispatch }, data) => {
      return api.post('/empleado/' + data.id + '/movimiento', data).then((response) => {
        return Promise.resolve()
      }, (error) => {
        return Promise.reject(error.response)
      })
    }
  },
  mutations: {
    // authentication
    setToken (state, token) {
      state.token = token
    },
    clearToken (state) {
      state.token = null
    },
    setUser (state, user) {
      state.user = user
    },
    clearUser (state) {
      state.user = {}
    },
    // next route
    nextRoute (state, route) {
      state.nextRoute = route
    },
    setCatalogos: (state, catalogos) => {
      state.catalogos = catalogos
    }
  },
  getters: {
    rootPath (state) {
      return state.rootPath
    },
    nextRoute (state) {
      return state.nextRoute
    },
    token (state) {
      return state.token
    },
    isAuthenticated (state) {
      return state.token !== null
    },
    user: state => {
      return state.user
    },
    catalogos: state => {
      return state.catalogos
    }
  }
})

export default store
