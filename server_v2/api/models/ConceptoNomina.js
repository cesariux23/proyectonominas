/**
* ConceptoNomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

// Se actualiza la sumatoria de acuerdo al tipo de concepto y se actializa el total del empleado
var actualizaTotales=function (registro, next) {
  //Solo funciona para registros individuales
  console.log('++++++++++++++++++++ OBJETO MODIFICADO +++++++++++++++++++++++++');
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
  ConceptoNomina.find({empleado: emp})
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
       console.log('********* SUMAS *************');
       console.log(result);
       result.forEach((total)=>{
         if(total.tipo_concepto == 'PERCEPCION') {
           obj.total_percepciones = total.monto.toFixed(2),
           obj.total_excento_percepciones = total.monto_exento.toFixed(2)
         } else {
           obj.total_deducciones = total.monto.toFixed(2)
           obj.total_excento_deducciones+= total.monto_exento.toFixed(2)
         }
       });
       console.log('------ >> empleado actualizado');
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
    //se liga el id del concepto_fijo
    concepto_fijo:{
      model:'conceptofijo'
    },
    editable: {
      type: 'boolean',
      required: true,
      defaultsTo: false
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
