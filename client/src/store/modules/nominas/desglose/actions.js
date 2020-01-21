import api from '@/api'

const getDesglose = ({ commit }, [nomina, desglose]) => {
  let url = `/nomina/${nomina}/desglose/${desglose}`
  return api.get(url).then((response) => {
    commit('addDesglose', response.data)
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

const addDesglose = ({ commit }, [nomina, data]) => {
  let url = `/nomina/${nomina}/desglose`
  return api.post(url, data).then((response) => {
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
  addDesglose,
  addConcepto,
  updateConcepto,
  deleteConcepto
}
