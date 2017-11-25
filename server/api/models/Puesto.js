/**
 * Puesto.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
	tableName:'puestos',
  attributes: {
  	empleado: {
  		model: 'Empleado'
  	},
  	funcion: {
  		type: 'string'
  	},
  	adscipcion: {
  		model: 'Adscripcion'
  	},
  	plaza: {
  		model: 'Plaza'
  	},
  	fecha_inicio: {
      type: 'date'
    },
    fecha_fin: {
      type: 'date'
    }
  }
};

