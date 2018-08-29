// Lista de nominas
const setNominas = (state, list) => {
  state.nominas = list
}

// agregar nominas a la lista
const addNomina = (state, nomina) => {
    // si el id de la nomina nuevo existe, se actualiza el registro
  const nominas = state.nominas.filter(_nomina => _nomina.id !== nomina.id)
  nominas.push(nomina)
  state.nominas = nominas
}

export {
  setNominas,
  addNomina
}
