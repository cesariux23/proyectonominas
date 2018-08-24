// Lista de nominas
const setProcesos = (state, list) => {
  state.procesos = list
}

// agregar nominas a la lista
const addProceso = (state, proceso) => {
    // si el id de la nomina nuevo existe, se actualiza el registro
  const procesos = state.procesos.filter(_proceso => _proceso.id !== proceso.id)
  procesos.push(proceso)
  state.procesos = procesos
}

export {
  setProcesos,
  addProceso
}
