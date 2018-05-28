import api from '@/api'

const fetchEmpleados = ({ state, commit }) => {
  state.isLoadingEmpleadosList = true
  api.get('/empleado').then((response) => {
    commit('setEmpleados', response.data)
    state.isLoadingEmpleadosList = false
  }, (err) => {
    console.log(err.response)
    return err
  })
}
const saveEmpleado = ({ commit }, empleado) => {
  return api.post('/empleado', empleado)
}

const updateEmpleado = ({ commit }, data) => {
  return api.patch('/empleado/' + data.id, data.data).then((response) => {
    console.log(response.data)
    commit('addEmpleado', response.data)
    return response.data
  }, (error) => {
    return Promise.reject(error.response)
  })
}
const getEmpleado = ({ commit }, [id, searchBy = false]) => {
  let data
  let url = '/empleado/'
  if (searchBy) {
    let params = {}
    params[searchBy] = id
    data = {params}
  } else {
    url += id
  }
  return api.get(url, data).then((response) => {
    let empleado = response.data
    if (searchBy) {
      empleado = response.data.length ? response.data[0] : false
    }
    if (empleado) {
      commit('addEmpleado', empleado)
    }
    return Promise.resolve(empleado)
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
