'use strict';

const service = require('feathers-sequelize');
const Concepto = require('./Concepto-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: Concepto(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false
  };

  // Initialize our service with any options it requires
  app.use('/Conceptos', service(options));

  // Get our initialize service to that we can bind hooks
  const ConceptoService = app.service('/Conceptos');

  // Set up our before hooks
  ConceptoService.before(hooks.before);

  // Set up our after hooks
  ConceptoService.after(hooks.after);
};
