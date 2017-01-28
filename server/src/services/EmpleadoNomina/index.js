'use strict';

const service = require('feathers-sequelize');
const EmpleadoNomina = require('./EmpleadoNomina-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: EmpleadoNomina(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false
  };

  // Initialize our service with any options it requires
  app.use('/EmpleadoNominas', service(options));

  // Get our initialize service to that we can bind hooks
  const EmpleadoNominaService = app.service('/EmpleadoNominas');

  // Set up our before hooks
  EmpleadoNominaService.before(hooks.before);

  // Set up our after hooks
  EmpleadoNominaService.after(hooks.after);
};
