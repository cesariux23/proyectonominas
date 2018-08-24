// agregar empleados a la lista
const addDesglose = (state, des) => {
    // si el id del empleado nuevo existe, se actualiza el registro
  const desgloses = state.desgloses.filter(_des => _des.id !== des.id)
  desgloses.push(des)
  state.desgloses = desgloses
}

export {
  addDesglose
}
