/**
* ConceptoNomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

// Se actualiza la sumatoria de acuerdo al tipo de concepto y se actializa el total del empleado
var actualizaTotales=function (registro, next) {
  //Solo funciona para registros individuales
  ConceptoNomina.find({empleado: registro.empleado})
    .groupBy('tipo_concepto')
    .sum(['monto', 'monto_exento'])
    .exec((error, result) =>{
      if (error) {
        console.log('Error:');
         console.log(error);
         return;
       }
       var obj={
         total_percepciones: 0,
         total_excento_percepciones: 0,
         total_deducciones: 0,
         total_excento_deducciones: 0
       };
       result.forEach((total)=>{
         if(total.tipo_concepto == 'PERCEPCION') {
           obj.total_percepciones = total.monto,
           obj.total_excento_percepciones = total.monto_exento
         } else {
           obj.total_deducciones = total.monto,
           obj.total_excento_deducciones = total.monto_exento
         }
       });
       console.log('------');
       console.log(registro);
       var emp=0;
       if(typeof registro.empleado == 'undefined'){
         //forza la deteccion del id del empleado
         e=JSON.parse(JSON.stringify(registro[0]));
         console.log(e);
         emp=e.empleado;
       }
       else {
         emp=registro.empleado;
       }
       console.log(emp);
      EmpleadoNomina.update({id:emp},obj).exec((err, upd)=>{
        if (err) {
          console.log('Error:');
           console.log(err);
           return;
         }
         console.log(upd);
      });
    });
  next();
};

module.exports = {

  attributes: {
    empleado: {
      model: 'EmpleadoNomina'
    },
    // se agrega la clave del concepto que contiene informacion adicional para el timbrado e informes
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
    }
  },
  afterCreate: actualizaTotales,
  afterUpdate: actualizaTotales,
  // cuando se borra el registro individialmente
  afterDestroy: actualizaTotales
};
