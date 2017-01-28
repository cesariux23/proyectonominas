'use strict';

// CatalogoNomina-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const CatalogoNomina = sequelize.define('catalogo_nominas', {
    descripcion : {
      type: Sequelize.STRING,
      allowNull: false
    },
    periodicidad : {
      type: Sequelize.ENUM('QUINCENAL', 'MENSUAL', 'BIMESTRAL', 'TRIMESTRAL', 'SEMESTRAL', 'ANUAL'),
      allowNull: false
    },
    activa: {
      type: Sequelize.BOOLEAN,
      defaultValue: true
    }
  }, {
    freezeTableName: true,
    underscored: true
  });

  CatalogoNomina.sync();

  return CatalogoNomina;
};
