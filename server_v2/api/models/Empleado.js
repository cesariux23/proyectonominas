/**
* HistorialLaboral.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {
  tableName:'empleados',
  attributes: {
    adscripcion: {
      model: 'adscripcion'
    },
    datos_personales: {
      model: 'personal',
      required: true
    },
    fecha_inicio: {
      type: 'date'
    },
    puesto: {
      type: 'string',
      required: true,
      defaultsTo: 'AUXILIAR'
    },
    fecha_fin: {
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
