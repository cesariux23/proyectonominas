// Lista de nominas
const setNominas = (state, list) => {
  state.nominas = list
}

// agregar nominas a la lista
const addNomina = (state, nom) => {
    // si el id de la nomina nuevo existe, se actualiza el registro
  const nominas = state.nominas.filter(_nom => _nom.id !== nom.id)
  nominas.push(nom)
  state.nominas = nominas
}

export {
  setNominas,
  addNomina
}
