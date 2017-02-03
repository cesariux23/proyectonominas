'use strict';

// src\services\nomina\hooks\cargaEmpleadosNomina.js
//
// Use this hook to manipulate incoming or outgoing data.
// For more information on hooks see: http://docs.feathersjs.com/hooks/readme.html

const defaults = {};

module.exports = function(options) {
  options = Object.assign({}, defaults, options);

  return function(hook) {
    let id_catalogo_nomina=hook.result.id_catalogo_nomina;
    var id = hook.result.id;
    hook.app.service('/EmpleadoNominas').find({id_nomina: id_catalogo_nomina}).then(empleados => {
      //recorre cada empleado asociado a la nomina y los carga en el total empleados
      empleados.forEach(function(em) {
        //inserta en total empleados
        hook.app.service('/TotalEmpleado').create({id_nomina: id, id_empleado_nomina: em.id});

      });
    })
  };
};
