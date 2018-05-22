const empleados = state => state.empleados
const getEmpleadoById = (state, getters) => (id) => {
  return state.empleados.find(emp => emp.id === Number.parseInt(id))
}
const getEmpleadoByRFC = (state, getters) => (rfc) => {
  console.log(rfc)
  return state.empleados.find(emp => emp.datos_personales.rfc === rfc)
}

export {
  empleados,
  getEmpleadoById,
  getEmpleadoByRFC
}
