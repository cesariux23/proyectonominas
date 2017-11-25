/**
 * Plaza.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  tableName:'plazas',
  attributes: {
  	clave: {
      type: 'String',
      primaryKey: true
    },
    catalogo: {
      type: 'String'
    },
    nombre: {
      type: 'String',
      required: true
    },
   	nivel: {
      type: 'String'
    },
    zona: {
      type: 'integer'
    }
  }
};

