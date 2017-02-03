'use strict';

const service = require('feathers-sequelize');
const Adscripcion = require('./Adscripcion-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: Adscripcion(app.get('sequelize')),
    paginate: {
      default: 5,
      max: 25
    }
  };

  // Initialize our service with any options it requires
  app.use('/Adscripcions', service(options));

  // Get our initialize service to that we can bind hooks
  const AdscripcionService = app.service('/Adscripcions');

  // Set up our before hooks
  AdscripcionService.before(hooks.before);

  // Set up our after hooks
  AdscripcionService.after(hooks.after);
};
