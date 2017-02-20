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
      unique: true,
      required: true
    },
    tipo_concepto: {
      type: 'string',
      enum: ['PERCEPCION', 'DEDUCCION'],
      defaultsTo: 'DEDUCCION',
      required: true
    },
    //no deberia existir descripcion igual
    descripcion_general: {
      type: 'string',
      unique: true
    },
    //al agregar el concepto se puede editar la descripción
    descripcion_editable: {
      type: 'boolean',
      defaultsTo: false
    },
    //Se especifica a que tipo de empledo se puede aplicar el concepto
    aplica_empleado: {
      type: 'string',
      enum: ['BASE', 'CONFIANZA', 'HONORARIOS']
    },
    //valor inicia
    monto_inicial: {
      type: 'float'
    },

    porcentaje: {
      type: 'float'
    },
    //editar el valor al agregarlo
    valor_editable: {
      type: 'boolean',
      defaultsTo: false
    },
    /*
    ** se agregara la posibilidad de crear formulas
    */
    //se especifica el porcentaje excento
    excento: {
      type: 'float'
    },
    //el concepto se puede agregar a los conceptos fijos de los empleados
    fijable: {
      type: 'boolean',
      defaultsTo: false
    }
  }
};
