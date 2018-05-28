// empleados
const setEmpleados = (state, list) => {
  state.empleados = list
}

const addEmpleado = (state, emp) => {
    // si el id del empleado nuevo existe, se actualiza el registro
  const empleados = state.empleados.filter(_emp => _emp.id !== emp.id)
  empleados.push(emp)
  state.empleados = empleados
}

export {
  setEmpleados,
  addEmpleado
}
