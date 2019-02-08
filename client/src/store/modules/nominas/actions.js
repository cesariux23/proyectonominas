import api from '@/api'

// nominas
const saveNomina = (contex, nomina) => {
  return api.post('/nomina', nomina).then((response) => {
    return Promise.resolve(response.data)
  }, (error) => {
    return Promise.reject(error.response)
  })
}

const getNomina = ({ commit }, data) => {
  return api.get('/nomina/' + data.id).then((response) => {
    commit('addNomina', response.data)
    return Promise.resolve(response.data)
  }, (err) => {
    console.log(err.response)
    return err
  })
}

const fetchNominas = ({ state, commit }) => {
  api.get('/nomina').then((response) => {
    commit('setNominas', response.data)
  }, (err) => {
    console.log(err.response)
    return err
  })
}

export {
  saveNomina,
  getNomina,
  fetchNominas
}
