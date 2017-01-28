'use strict';

const service = require('feathers-sequelize');
const EmpleadoConcepto = require('./EmpleadoConcepto-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: EmpleadoConcepto(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate:false
  };

  // Initialize our service with any options it requires
  app.use('/EmpleadoConceptos', service(options));

  // Get our initialize service to that we can bind hooks
  const EmpleadoConceptoService = app.service('/EmpleadoConceptos');

  // Set up our before hooks
  EmpleadoConceptoService.before(hooks.before);

  // Set up our after hooks
  EmpleadoConceptoService.after(hooks.after);
};
