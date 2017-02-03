'use strict';

const service = require('feathers-sequelize');
const TotalEmpleado = require('./TotalEmpleado-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: TotalEmpleado(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false
  };

  // Initialize our service with any options it requires
  app.use('/TotalEmpleado', service(options));

  // Get our initialize service to that we can bind hooks
  const TotalEmpleadoService = app.service('/TotalEmpleado');

  // Set up our before hooks
  TotalEmpleadoService.before(hooks.before);

  // Set up our after hooks
  TotalEmpleadoService.after(hooks.after);
};
