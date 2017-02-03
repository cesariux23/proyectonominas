/**
* CatalogoNomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {

  attributes: {
    descripcion : {
      type: 'string',
      required: true
    },
    periodicidad : {
      type: 'string',
      enum: ['QUINCENAL', 'MENSUAL', 'BIMESTRAL', 'TRIMESTRAL', 'SEMESTRAL', 'ANUAL'],
      required: true
    },
    activa: {
      type: 'boolean',
      defaultsTo: true
    }
  }
};
