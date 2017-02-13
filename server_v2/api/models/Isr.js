/**
* Isr.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {

  attributes: {
    periodo: {
      type: 'string',
      enum: ['QUINCENAL', 'MENSUAL'],
      required: true
    },
    limite_inferior: {
      type: 'float',
      required: true
    },
    limite_superior: {
      type: 'float',
      required: true
    },
    cuota_fija: {
      type: 'float',
      required: true
    },
    limite_superior: {
      type: 'float',
      required: true
    },
    sobre_excedente: {
      type: 'float',
      required: true
    }
  }
};
