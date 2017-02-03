'use strict';

// src\services\Nomina\hooks\cargaDescripcion.js
//
// Use this hook to manipulate incoming or outgoing data.
// For more information on hooks see: http://docs.feathersjs.com/hooks/readme.html

const defaults = {};

module.exports = function(options) {
  options = Object.assign({}, defaults, options);

  return function(hook) {
    hook.result.dataValues.catalogonomina='holaa!';
      hook.app.service('CatalogoNominas').get(hook.result.dataValues.id_catalogo_nomina).then( r =>{
        hook.result.dataValues.catalogonomina=r.dataValues.descripcion;
        console.log(hook.result.dataValues);
      })

  };
};
