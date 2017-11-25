/**
* EmpleadoNomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

// Se actualiza la sumatoria de acuerdo al tipo de concepto y se actializa el total de la nomina
var actualizaTotalesNomina=function (registro, next) {
  EmpleadoNomina.find({nomina: registro.nomina})
    .sum(['total_percepciones','total_excento_percepciones', 'total_deducciones', 'total_excento_deducciones', 'total_isr'])
    .exec((error, result) =>{
      if (error) {
        console.log('Error:');
         console.log(error);
         return;
       }
       var obj={
         total_percepciones: result[0].total_percepciones.toFixed(2),
         total_excento_percepciones: result[0].total_excento_percepciones.toFixed(2),
         total_deducciones: result[0].total_deducciones.toFixed(2),
         total_excento_deducciones: result[0].total_excento_deducciones.toFixed(2),
         total_isr: result[0].total_isr.toFixed(2)
       };
       // se actualiza el registro
       Nomina.update({id:registro.nomina},obj).exec((err, upd)=>{
         if (err) {
           console.log('Error:');
            console.log(err);
            return;
          }
       });
    });
  next();
};

module.exports = {

  attributes: {
    // se liga con los datos personales
    datos_personales: {
      model: 'personal'
    },
    // al finalizar el porceso de nomina se fija los datos laborales actuales
    empleado: {
      model: 'empleado'
    },
    nomina: {
      model: 'nomina'
    },
    cargar_conceptos_fijos: {
      type: 'boolean',
      defaultsTo: false
    },
    editable: {
      type: 'boolean',
      defaultsTo: true
    },
    total_percepciones: {
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_excento_percepciones: {
      type:'float',
      required: true,
      defaultsTo: 0.0
    },
    total_deducciones: {
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_excento_deducciones: {
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_isr: {
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    total_neto: {
      type: 'float',
      required: true,
      defaultsTo: 0.0
    },
    conceptos: {
      collection: 'ConceptoNomina',
      via:'empleado'
    }
  },
  beforeUpdate: function (registro, next) {
    console.log('********************** Actualizar ***********************');
    // se calcula el isr conforme a las suma
    console.log('PERCEPCION');
    console.log(registro.total_percepciones);
    console.log('DEDUCCION');
    console.log(registro.total_deducciones);
    if (registro.total_percepciones > 0) {
      Isr.find({periodo:'QUINCENAL', limite_inferior: {'<=': registro.total_percepciones}, limite_superior: {'>': registro.total_percepciones}})
      .exec((err, tuplas_isr) => {
        if (err) {
          console.log('Error:');
           console.log(err);
           return;
         }
         console.log('__________________________ resultado ISR ________________________________');
         console.log(tuplas_isr);
         var isr = tuplas_isr[0];
         // se calcula el isr con el registro que coincida
         console.log('__________________________ TABLA ISR ________________________________');
         console.log(isr);
         var ex=(registro.total_percepciones - isr.limite_inferior)*(isr.sobre_excedente/100);
         registro.total_isr = (isr.cuota_fija + ex).toFixed(2);
         console.log('__________________________ ISR A ACTUALIZAR ________________________________');
         console.log(isr);
         console.log('===========================>' + registro.total_isr);
         console.log('todas las deducciones: ');
         var deducciones=parseFloat(registro.total_deducciones) + parseFloat(registro.total_isr)
         console.log(deducciones);
         registro.total_neto = parseFloat(registro.total_percepciones) - parseFloat(deducciones)
         console.log('neto:');
         console.log(registro.total_neto);
         next()
      });
    } else {
      registro.total_percepciones = 0;
      registro.total_isr=0;
      registro.total_neto = registro.total_percepciones - parseFloat(registro.total_deducciones)
      next()
    }
  },
  afterCreate: function (registro, next) {
    if(registro.cargar_conceptos_fijos){
      ConceptoFijo.find({empleado: registro.empleado, activo: true})
      .exec((error, result) =>{
        if (error) {
          console.log('Error:');
           console.log(error);
           return;
         }
         console.log('ConceptoFijos: ');
         result.forEach((r) => {
           var fijo = r;
           delete fijo.id;
           fijo.concepto_fijo = r.id;
           fijo.empleado = registro.id;
           //se inserta el la nomina actual
           ConceptoNomina.create(fijo)
           .exec((er, res) => {
             if (er) {
               console.log('Error:');
                console.log(er);
                return;
              }
              console.log(res);
           })
         })
      })
    } else {
      actualizaTotalesNomina(registro, next);
    }
  },
  afterUpdate:actualizaTotalesNomina
};
