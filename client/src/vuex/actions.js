import feathers from 'feathers/client'
import socketio from 'feathers-socketio/client'
import io from 'socket.io-client'
import rx from 'feathers-reactive'
import RxJS from 'rxjs'

const socket = io('http://localhost:3030')
const app = feathers()
  .configure(rx(RxJS))
  .configure(socketio(socket))

// Get the message service that uses a websocket connection
const empleadoServices = app.service('Empleados')
const nominaServices = app.service('Nominas')
const CatalogoNominaService = app.service('CatalogoNominas')

// Empleados
export const fetchEmpleados = function ({dispatch}) {
  // Call the messages service on the server via websocket
  empleadoServices.find().subscribe(result => {
    dispatch('FETCH_EMPLEADOS', result)
  })
}

export const addEmpleado = ({ dispatch }) => {
  dispatch('ADD_EMPLEADO')
}

// Nominas

export const fetchNominas = function ({dispatch}) {
  nominaServices.find().subscribe(result => {
    dispatch('FETCH_NOMINAS', result)
  })
}
export const fetchCatalogoNominas = function ({dispatch}) {
  CatalogoNominaService.find().subscribe(result => {
    dispatch('FETCH_CATALOGO_NOMINAS', result)
  })
}

export const addNomina = ({ dispatch }) => {
  dispatch('ADD_EMPLEADO')
}
