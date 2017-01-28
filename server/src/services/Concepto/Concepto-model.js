'use strict';

// Concepto-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const Concepto = sequelize.define('Conceptos', {
    clave: {
      type:Sequelize.STRING,
      allowNull: false,
      primaryKey: true
    },
    descripcion: {
      type: Sequelize.STRING,
      allowNull: true
    },
    tipo_concepto: {
      type: Sequelize.ENUM('PERCEPCION','DEDUCCION'),
      allowNull: true
    },
    de_ley: {
      type: Sequelize.BOOLEAN,
      allowNull: true,
      defaultValue: false
    },
    excento: {
      type: Sequelize.BOOLEAN,
      allowNull: true,
      defaultValue: false
    },
    repetir: {
      type: Sequelize.BOOLEAN,
      allowNull: true,
      defaultValue: false
    },
    agrupador: {
      type: Sequelize.STRING,
      allowNull: true

    },
    calcular: {
      type: Sequelize.BOOLEAN,
      allowNull: true,
      defaultValue: false
    },
    tipo: {
      type: Sequelize.STRING,
      allowNull: true
    },
    activa: {
      type: Sequelize.BOOLEAN,
      allowNull: true,
      defaultValue: true
    },
  }, {
    freezeTableName: true,
    underscored:true
  });

  Concepto.sync();

  return Concepto;
};
