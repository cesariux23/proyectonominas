import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  personal: [],
  empleados: [],
  nominas: [],
  catalogoNominas: []
}

const mutations = {
  // personal
  FETCH_PERSONAL (state, personal) {
    state.personal = personal
  },
  ADD_PERSONAL (state, personal) {
    state.personal.push(personal)
  },
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
  ADD_NOMINA (state, nomina) {
    state.nominas.push(nomina)
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
