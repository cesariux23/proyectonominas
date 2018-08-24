import api from '@/api'

// nominas
const saveProceso = (contex, nomina) => {
  return api.post('/proceso', nomina).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

const getProceso = ({ commit }, data) => {
  return api.get('/proceso/' + data.id).then((response) => {
    commit('addProceso', response.data)
  }, (err) => {
    console.log(err.response)
    return err
  })
}

const fetchProcesos = ({ state, commit }) => {
  api.get('/proceso').then((response) => {
    commit('setProcesos', response.data)
  }, (err) => {
    console.log(err.response)
    return err
  })
}

export {
  saveProceso,
  getProceso,
  fetchProcesos
}
