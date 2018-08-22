import api from '@/api'

/*
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
*/
const getDesglose = ({ commit }, [nomina, id]) => {
  let url = `/nomina/${nomina}/desglose/${id}`
  return api.get(url).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

export {
  getDesglose
}
