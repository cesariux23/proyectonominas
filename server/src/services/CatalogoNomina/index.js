'use strict';

const service = require('feathers-sequelize');
const CatalogoNomina = require('./CatalogoNomina-model');
const hooks = require('./hooks');

module.exports = function(){
  const app = this;

  const options = {
    Model: CatalogoNomina(app.get('sequelize')),
    // paginate: {
    //   default: 5,
    //   max: 25
    // }
    paginate: false
  };

  // Initialize our service with any options it requires
  app.use('/CatalogoNominas', service(options));

  // Get our initialize service to that we can bind hooks
  const CatalogoNominaService = app.service('/CatalogoNominas');

  // Set up our before hooks
  CatalogoNominaService.before(hooks.before);

  // Set up our after hooks
  CatalogoNominaService.after(hooks.after);
};
