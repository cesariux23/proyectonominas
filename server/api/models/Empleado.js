/**
* HistorialLaboral.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {
  tableName:'empleados',
  attributes: {
    datos_personales: {
      model: 'personal',
      required: true
    },
    tipo_contrato: {
      type: 'string',
      enum: ['BASE', 'CONFIANZA', 'HONORARIOS'],
      required: true,
      defaultsTo: 'HONORARIOS'
    },
    numero_empleado: {
      type: 'String'
    },
    interinato: {
      type: 'boolean'
    },
    puesto: {
      model: 'Puesto',
      required: true
    },
    historial: {
      collection: 'Puesto',
      via: 'empleado'
    },
    status: {
      type: 'String',
      enum: ['ACTIVO', 'LICENCIA', 'BAJA'],
      required: true,
      defaultsTo: 'ACTIVO'
    },
    fecha_alta: {
      type: 'date'
    },
    fecha_baja: {
      type: 'date'
    }
  },

  afterCreate: function (registro, next) {
    // se actualiza el historial del empleado al ultimo para poder determinar cual es actual
    if(typeof registro.fecha_fin === 'undefined' || registro.fecha_fin === null){
      Empleado.update({id: registro.empleado}, {puesto: registro.id}).exec((err, upd)=>{
        if (err) {
           console.log(err);
           return;
         }
      });
    }
    next();
  }
};
