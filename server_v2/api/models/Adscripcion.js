/**
* Adscripcion.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {
  tableName: 'adscripciones',
  attributes: {
    unidad: {type: 'integer', required: true},
    subunidad: {type: 'integer', defaultsTo: 0},
    adscripcion: { type: 'string', required: true, unique: true},
  }
};
