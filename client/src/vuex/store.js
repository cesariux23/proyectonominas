import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  // Quincena activa
  empleados: [],
  nominas: []
}

const mutations = {
  ADD_EMPLEADO (state) {

  },
  FETCH_EMPLEADOS (state, empleados) {
    state.empleados = empleados
  }
}

const store = new Vuex.Store({
  state,
  mutations
})
export default store
