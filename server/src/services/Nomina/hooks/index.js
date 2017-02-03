'use strict';

const cargaDescripcion = require('./cargaDescripcion');

const cargaEmpleadosNomina = require('./cargaEmpleadosNomina');

const globalHooks = require('../../../hooks');
const hooks = require('feathers-hooks');
const hooksCommon = require('feathers-hooks-common');


exports.before = {
  all: [],
  find: [],
  get: [],
  create: [],
  update: [],
  patch: [],
  remove: []
};

exports.after = {
  all: [],
  find: [cargaDescripcion()],
  get: [cargaDescripcion()],
  create: [cargaEmpleadosNomina()],
  update: [],
  patch: [],
  remove: []
};
