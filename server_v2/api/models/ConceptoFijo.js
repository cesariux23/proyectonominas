/**
* ConceptoFijo.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {

  attributes: {
    empleado:{
      model:'empleado'
    },
    clave:{
      model:'CatalogoConcepto'
    },
    tipo_concepto: {
      type: 'string',
      enum: ['PERCEPCION', 'DEDUCCION'],
      defaultsTo: 'DEDUCCION',
      required: true
    },
    descripcion: {
      type: 'string',
      required: true
    },
    porcentaje: {
      type: 'float'
    },
    monto: {
      type: 'float',
      defaultsTo: 0.0,
      required: true
    },
    monto_exento: {
      type: 'float',
      defaultsTo: 0.0,
      required: true
    },
    activo: {
      type: 'boolean',
      defaultsTo: true
    }
  }
};
