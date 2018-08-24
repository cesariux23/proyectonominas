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
const getDesglose = ({ commit }, [proceso, desglose]) => {
  let url = `/proceso/${proceso}/desglose/${desglose}`
  return api.get(url).then((response) => {
    commit('addDesglose', response.data)
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

const addConcepto = ({ commit }, [desglose, data]) => {
  let url = `/desglose/concepto`
  return api.post(url, data).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}
const updateConcepto = ({ commit }, data) => {
  return api.put('/desglose/concepto/' + data.id, data.data).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}
const deleteConcepto = ({ commit }, id) => {
  return api.delete('/desglose/concepto/' + id).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

export {
  getDesglose,
  addConcepto,
  updateConcepto,
  deleteConcepto
}
