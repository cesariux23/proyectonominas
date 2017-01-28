'use strict';
const empleadoConcepto = require('./EmpleadoConcepto');
const catalogoNomina = require('./CatalogoNomina');
const concepto = require('./Concepto');
const empleadoNomina = require('./EmpleadoNomina');
const nomina = require('./Nomina');
const empleado = require('./Empleado');
const authentication = require('./authentication');
const user = require('./user');
const Sequelize = require('sequelize');
module.exports = function() {
  const app = this;

  const sequelize = new Sequelize(app.get('mysql'), {
    dialect: 'mysql',
    logging: false
  });
  app.set('sequelize', sequelize);

  app.configure(authentication);
  app.configure(user);
  app.configure(empleado);
  app.configure(nomina);
  app.configure(concepto);
  app.configure(empleadoNomina);
  app.configure(catalogoNomina);
  app.configure(empleadoConcepto);
};
