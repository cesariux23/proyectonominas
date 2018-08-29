const nominas = state => state.nominas
const getNominaById = (state, getters) => (id) => {
  return state.nominas.find(nomina => nomina.id === Number.parseInt(id))
}

export {
  nominas,
  getNominaById
}
