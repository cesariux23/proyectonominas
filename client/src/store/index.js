import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    empleados: [],
    catalogos: {},
    isLoadingEmpleadosList: false
  },
  actions: {
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
    /*
    getEmpleado: ({ commit }, id) => {
      return axios.get('/empleado/' + id)
    */
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
