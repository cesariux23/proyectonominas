'use strict';

const service = require('feathers-sequelize');
const Empleado = require('./Empleado-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: Empleado(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false,
    lean: true
  };

  // Initialize our service with any options it requires
  app.use('/Empleados', service(options));

  // Get our initialize service to that we can bind hooks
  const EmpleadoService = app.service('/Empleados');

  // Set up our before hooks
  EmpleadoService.before(hooks.before);

  // Set up our after hooks
  EmpleadoService.after(hooks.after);
};
