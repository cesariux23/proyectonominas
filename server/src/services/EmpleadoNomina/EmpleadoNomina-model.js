'use strict';

// EmpleadoNomina-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

module.exports = function(sequelize) {
  const EmpleadoNomina = sequelize.define('empleado_nomina', {
    id_empleado: {
        type: Sequelize.INTEGER,
        allowNull: false
      },
      id_nomina:
        { type: Sequelize.INTEGER,
          allowNull: false
        },
       activo:
        { type: Sequelize.BOOLEAN,
          allowNull: true,
          defaultValue: true
        },
    }, {
      freezeTableName: true,
      underscored:true
    });

  EmpleadoNomina.sync();

  return EmpleadoNomina;
};
