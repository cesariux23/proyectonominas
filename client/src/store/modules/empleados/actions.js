import axios from 'axios'

const fetchEmpleados = ({ state, commit }) => {
  state.isLoadingEmpleadosList = true
  axios.get('/empleado').then((response) => {
    commit('setEmpleados', response.data)
    state.isLoadingEmpleadosList = false
  }, (err) => {
    console.log(err.response)
    return err
  })
}
const saveEmpleado = ({ commit }, empleado) => {
  return axios.post('/empleado', empleado)
}

const updateEmpleado = ({ commit }, data) => {
  return axios.patch('/empleado/' + data.id, data.data).then((response) => {
    commit('addEmpleado', response.data)
    return response.data
  }, (error) => {
    return Promise.reject(error.response)
  })
}
const getEmpleado = ({ commit }, id) => {
  return axios.get('/empleado/' + id).then((response) => {
    commit('addEmpleado', response.data)
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

export {
  fetchEmpleados,
  saveEmpleado,
  updateEmpleado,
  getEmpleado
}
