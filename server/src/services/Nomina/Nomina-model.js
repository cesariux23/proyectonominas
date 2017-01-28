'use strict';

// Nomina-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const Nomina = sequelize.define('Nominas', {
    id_catalogo_nomina:{
      type: Sequelize.INTEGER,
      allowNull: true,
    },
    periodo_inicio:{
      type: Sequelize.STRING(8),
      allowNull: false
    },
    periodo_fin:{
      type: Sequelize.STRING(8),
      allowNull: true
    },
    descripcion:{
      type: Sequelize.STRING,
      allowNull: true
    },
    tipo_nomina:{
      type: Sequelize.ENUM('ORDINARIO','EXTRAORDINARIO','OTRO'),
      allowNull: true
    },
    total_percepciones:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: true
    },
    total_excento_percepciones:{
      type:Sequelize.DECIMAL(10,2),
      allowNull: false,
      defaultValue: '0'
    },
    total_deducciones:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: true
    },
    total_excento_deducciones:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: true
    },
    total_isr:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: false
    },
    total_neto:{
      type: Sequelize.DECIMAL(10,2),
      allowNull: false
    },
    estado:{
      type: Sequelize.ENUM('EN_PROCESO','FIN_ELABORACION','PENDIENTE_PAGO','APLICADA','CANCELADA'),
      allowNull: true
    },
    numero_empleados:{
      type: Sequelize.INTEGER,
      allowNull: true
    },
  }, {
    freezeTableName: true,
    underscored:true
  });
  
  Nomina.sync();

  return Nomina;
};
