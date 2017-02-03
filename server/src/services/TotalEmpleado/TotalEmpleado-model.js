'use strict';

// TotalEmpleado-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const TotalEmpleado = sequelize.define('total_empleado', {
    id_nomina: {
      type: Sequelize.INTEGER,
      allowNull: false
    },
    id_empleado_nomina: {
      type: Sequelize.INTEGER,
      allowNull: false
    },
    puesto: {
      type: Sequelize.STRING(45),
      allowNull: true
    },
    id_adscripcion: {
      type: Sequelize.INTEGER,
      allowNull: true
    },
    total_percepciones: {
      type: Sequelize.DECIMAL(10,2),
      allowNull: false,
      defaultValue: '0'
    },
    total_excento_percepciones:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: false,
      defaultValue: '0'
    },
    total_deducciones: {
      type: Sequelize.DECIMAL(10,2),
      allowNull: false,
      defaultValue: '0'
    },
    total_excento_deducciones: {
      type: Sequelize.DECIMAL(10,2),
      allowNull: true,
    },
    total_isr: {
      type: Sequelize.DECIMAL(10,0),
      allowNull: false,
      defaultValue: '0'
    },
    total_neto: {
      type: Sequelize.DECIMAL(10,0),
      allowNull: true,
      defaultValue: '0'
    },
    tipo_pago: {
      type: Sequelize.ENUM('CHEQUE', 'DEPOSITO'),
      allowNull: true,
      defaultValue: 'CHEQUE'
    },
    banco: {
      type: Sequelize.STRING(45),
      allowNull: true
    },
    num_cuenta: {
      type: Sequelize.STRING(20),
      allowNull: true
    },
  }, {
    freezeTableName: true,
    underscored:true
  });

  TotalEmpleado.sync();

  return TotalEmpleado;
};
