/**
* CatalogoConcepto.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {

  attributes: {
    clave:{
      type: 'string',
      primaryKey: true,
      required: true
    },
    tipo_concepto: {
      type: 'string',
      enum: ['PERCEPCION', 'DEDUCCION'],
      defaultsTo: 'DEDUCCION',
      required: true
    },
    //no deberia existir descripciones parecidas
    descripcion_general: {
      type: 'string',
      unique: true
    },
    //valor inicia
    monto_inicial: {
      type: 'float'
    },
    procentaje_inicial: {
      type: 'float'
    },
    /*
    ** se agregara la posibilidad de crear formulas
    */
    grabable: {
      type: 'boolean',
      defaultsTo: false
    },
    //el concepto se puede agregar a los conceptos fijos de los empleados
    es_fijable: {
      type: 'boolean',
      defaultsTo: false
    }

  }
};
