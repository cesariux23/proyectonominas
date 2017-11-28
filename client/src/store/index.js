import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    empleados: [],
    catalogos: {},
    isLoadingEmpleadosList: false,
    token: null,
    user: {}
  },
  actions: {
    // Autenticacion
    login ({ state, commit }, creds) {
      return axios.post('/auth/login', creds).then((response) => {
        commit('setToken', response.data.token)
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
    // empleados
    fetchEmpleados: ({ state, commit }) => {
      state.isLoadingEmpleadosList = true
      axios.get('/empleado').then((response) => {
        commit('setEmpleados', response.data)
        state.isLoadingEmpleadosList = false
      }, (err) => {
        console.log(err)
        return err
      })
    },
    saveEmpleado: ({ commit }, empleado) => {
      return axios.post('/empleado', empleado)
    },
    updateEmpleado: ({ commit }, data) => {
      return axios.patch('/empleado/' + data.id, data.data).then((response) => {
        commit('addEmpleado', response.data)
        return response.data
      }, (err) => {
        console.log(err)
        return err
      })
    },
    getEmpleado: ({ commit }, id) => {
      return axios.get('/empleado/' + id).then((response) => {
        commit('addEmpleado', response.data)
        return response.data
      }, (err) => {
        console.log(err)
        return err
      })
    },
    // catalogos
    fetchCatalogos: ({ commit }) => {
      axios.get('/catalogos').then((response) => {
        commit('setCatalogos', response.data)
      }, (err) => {
        console.log(err)
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
    // empleados
    setEmpleados: (state, list) => {
      state.empleados = list
    },
    addEmpleado: (state, emp) => {
      // si el id del empleado nuevo existe, se actualiza el registro
      state.empleados = state.empleados.filter(_emp => _emp.id !== Number.parseInt(emp.id))
      state.empleados.push(emp)
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
    },
    // filtran el state
    getEmpleadoById: (state, getters) => (id) => {
      return state.empleados.find(emp => emp.id === Number.parseInt(id))
    }
  }
})
export default store
