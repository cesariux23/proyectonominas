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
// const empleadosServices = app.service('empleados')

export const fetchEmpleados = function ({dispatch}) {
  // Call the messages service on the server via websocket
  app.service('/Empleados').find().subscribe(result => {
    dispatch('FETCH_EMPLEADOS', result)
  })
}

export const addEmpleado = ({ dispatch }) => {
  dispatch('ADD_EMPLEADO')
}
