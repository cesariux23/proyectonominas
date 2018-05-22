// empleados
const setEmpleados = (state, list) => {
  state.empleados = list
}

const addEmpleado = (state, emp) => {
    // si el id del empleado nuevo existe, se actualiza el registro
  state.empleados = state.empleados.filter(_emp => _emp.id !== Number.parseInt(emp.id))
  state.empleados.push(emp)
}

export {
  setEmpleados,
  addEmpleado
}
