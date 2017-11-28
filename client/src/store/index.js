import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    empleados: [],
    catalogos: {},
    isLoadingEmpleadosList: false,
    isLoggedIn: !!localStorage.getItem('token')
  },
  actions: {
    // Autenticacion
    login ({ state, commit }, creds) {
      return axios.post('/auth/login', creds).then((response) => {
        localStorage.setItem('token', response.data.token)
        return state.isLoggedIn
      }, (err) => {
        return err
      })
    },
    logout ({ commit }) {
      localStorage.removeItem('token')
    },
    // empleados
    fetchEmpleados: ({ state, commit }) => {
      state.isLoadingEmpleadosList = true
      axios.get('/empleado').then((response) => {
        commit('setEmpleados', response.data)
        state.isLoadingEmpleadosList = false
      }, (err) => {
        console.log(err)
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
    // filtran el state
    getEmpleadoById: (state, getters) => (id) => {
      return state.empleados.find(emp => emp.id === Number.parseInt(id))
    }
  }
})
export default store
