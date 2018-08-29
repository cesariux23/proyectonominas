const desgloses = state => state.desgloses
const getDesgloseById = (state, getters) => (id) => {
  return state.desgloses.find(des => des.id === Number.parseInt(id))
}

export {
  desgloses,
  getDesgloseById
}
