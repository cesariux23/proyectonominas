// import feathers from 'feathers/client'
// import socketio from 'feathers-socketio/client'
// import io from 'socket.io-client'
// import rx from 'feathers-reactive'
// import RxJS from 'rxjs'
// import router from '../router'

import socketIOClient from 'socket.io-client'
import sailsIOClient from 'sails.io.js'

// const socket = io('http://localhost:3030')
// const app = feathers()
//   .configure(rx(RxJS))
//   .configure(socketio(socket))

const io = sailsIOClient(socketIOClient)
io.sails.url = 'http://localhost:1337'

// Get the message service that uses a websocket connection
// const empleadoServices = app.service('Empleados')
// const nominaServices = app.service('Nominas')
// const CatalogoNominaService = app.service('CatalogoNominas')

// subscribciones
io.socket.on('personal', function (event) {
  console.log('Escuchando')
  console.log(event)
})

// personal
export const fetchPersonal = function ({dispatch}) {
  io.socket.get('/personal', function (result) {
    dispatch('FETCH_PERSONAL', result)
  })
}
export const addPersonal = function ({dispatch}, personal) {
  // let _nomina = JSON.parse(JSON.stringify(nomina))
  io.socket.post('/personal', personal, (result) => {
    console.log(result)
    dispatch('ADD_PERSONAL', result)
  })
}

// Empleados
export const fetchEmpleados = function ({dispatch}) {
  // Call the messages service on the server via websocket
  // empleadoServices.find().subscribe(result => {
  // io.
  //   dispatch('FETCH_EMPLEADOS', result)
  // })
  io.socket.get('/empleado', function (result) {
    console.log(result)
    dispatch('FETCH_EMPLEADOS', result)
  })
}

export const addEmpleado = ({ dispatch }) => {
  dispatch('ADD_EMPLEADO')
}

// // Nominas
export const fetchNominas = function ({dispatch}) {
  io.socket.get('/nomina', function (result) {
    dispatch('FETCH_NOMINAS', result)
  })
}
// guarda nomina en la base de datos
export const addNomina = function ({dispatch}, nomina) {
  // let _nomina = JSON.parse(JSON.stringify(nomina))
  io.socket.post('/nomina', nomina, (result) => {
    dispatch('ADD_NOMINA', result)
  })
}

// guarda nomina en la base de datos
export const getNomina = function (id, cb) {
  // let _nomina = JSON.parse(JSON.stringify(nomina))
  io.socket.get('/nomina', {id: id}, cb)
}
export const fetchCatalogoNominas = function ({dispatch}) {
  io.socket.get('/catalogonomina', function (result) {
    console.log(result)
    dispatch('FETCH_CATALOGO_NOMINAS', result)
  })
}
// adscripciones
