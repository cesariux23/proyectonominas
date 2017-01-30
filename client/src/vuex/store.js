import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  // Quincena activa
  empleados: [],
  nominas: [],
  catalogoNominas: []
}

const mutations = {
  // Empleados
  ADD_EMPLEADO (state) {

  },
  FETCH_EMPLEADOS (state, empleados) {
    state.empleados = empleados
  },
  // Nominas
  FETCH_NOMINAS (state, nominas) {
    state.nominas = nominas
  },
  FETCH_CATALOGO_NOMINAS (state, catalogoNominas) {
    state.catalogoNominas = catalogoNominas
  }
}

const store = new Vuex.Store({
  state,
  mutations
})
export default store
