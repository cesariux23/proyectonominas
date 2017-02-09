/**
* EmpleadoNomina.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

// Se actualiza la sumatoria de acuerdo al tipo de concepto y se actializa el total de la nomina
var actualizaTotalesNomina=function (registro, next) {
  EmpleadoNomina.find({nomina: registro.nomina})
    .sum(['total_percepciones','total_excento_percepciones', 'total_deducciones', 'total_excento_deducciones'])
    .exec((error, result) =>{
      if (error) {
        console.log('Error:');
         console.log(error);
         return;
       }
       console.log(result);
       var obj={
         total_percepciones: result[0].total_percepciones,
         total_excento_percepciones: result[0].total_excento_percepciones,
         total_deducciones: result[0].total_deducciones,
         total_excento_deducciones: result[0].total_excento_deducciones
       };
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
           })
         })
      })
    } else {
      actualizaTotalesNomina(registro, next);
    }
  },
  afterUpdate:actualizaTotalesNomina
};
