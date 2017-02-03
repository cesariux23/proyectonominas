'use strict';

const service = require('feathers-sequelize');
const Nomina = require('./Nomina-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: Nomina(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false,
    raw: true
  };

  // Initialize our service with any options it requires
  app.use('/Nominas', service(options));

  // Get our initialize service to that we can bind hooks
  const NominaService = app.service('/Nominas');

  // Set up our before hooks
  NominaService.before(hooks.before);

  // Set up our after hooks
  NominaService.after(hooks.after);
};
