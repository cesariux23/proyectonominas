'use strict';

// EmpleadoConcepto-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const EmpleadoConcepto = sequelize.define('empleado_conceptos', {
    id_empleado_nomina: {
      type: Sequelize.INTEGER,
      allowNull: false
    },
    clave_concepto: {
      type: Sequelize.STRING(25),
      allowNull: false
    },
    monto: {
      type: Sequelize.DECIMAL(10,2),
      allowNull: false
    },
    monto_exento: {
      type: Sequelize.DECIMAL(10,2),
      allowNull: true
    },
    contador_aplicaciones: {
      type: Sequelize.INTEGER,
      allowNull: true
    },
    total_aplicaciones: {
      type: Sequelize.INTEGER,
      allowNull: true
    },
    formula: {
      type: Sequelize.STRING(45),
      allowNull: true
    }
  }, {
    freezeTableName: true,
    underscored: true,
    version: true
  });

  EmpleadoConcepto.sync();

  return EmpleadoConcepto;
};
