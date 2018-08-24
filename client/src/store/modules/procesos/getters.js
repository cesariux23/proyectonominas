const procesos = state => state.procesos
const getProcesoById = (state, getters) => (id) => {
  return state.procesos.find(proceso => proceso.id === Number.parseInt(id))
}

export {
  procesos,
  getProcesoById
}
