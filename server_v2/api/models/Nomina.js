/**
* Nomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {

  attributes: {
    tipo_nomina:{
      model:'CatalogoNomina'
    },
    tipo_emision:{
      type: 'string',
      enum: ['ORDINARIO','EXTRAORDINARIO'],
      defaultsTo: 'ORDINARIO',
      required: true
    },
    descripcion:{
      type: 'string',
      required: true
    },
    tipo_nomina:{
      model:'CatalogoNomina'
    },
    anio: {
      type: 'integer',
      required: true
    },
    periodo_inicio:{
      type: 'string',
      required: true
    },
    periodo_fin:{
      type: 'string',
      required: true
    },
    // TOTALES
    total_percepciones:{
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_excento_percepciones:{
      type:'float',
      required: true,
      defaultsTo: 0.0
    },
    total_deducciones:{
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_excento_deducciones:{
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_isr:{
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_neto:{
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    status:{
      type: 'string',
      enum: ['EN_PROCESO','FIN_ELABORACION','PENDIENTE_PAGO','APLICADA','CANCELADA'],
      required: true,
      defaultsTo: 'EN_PROCESO'
    },
    empleados:{
      collection: 'EmpleadoNomina',
      via: 'nomina'
    }
  }
};
