const empleados = state => state.empleados
const getEmpleadoById = (state, getters) => (id) => {
  return state.empleados.find(emp => emp.id === Number.parseInt(id))
}

export {
  empleados,
  getEmpleadoById
}
