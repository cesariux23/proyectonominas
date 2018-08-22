const nominas = state => state.nominas
const getNominaById = (state, getters) => (id) => {
  return state.nominas.find(nom => nom.id === Number.parseInt(id))
}

export {
  nominas,
  getNominaById
}
