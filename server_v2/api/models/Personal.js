/**
* Empleado.js
*
* @description :: TODO: You might write a short summary of how this model works and what it represents here.
* @docs        :: http://sailsjs.org/#!documentation/models
*/

module.exports = {
  tableName: 'personal',
  attributes: {
    fecha_ingreso: {
      type: 'Date'
    },
    //se generará un registro por tipo de contrato, no por persona
    tipo_contrato: {
      type: 'string',
      enum: ['BASE', 'CONFIANZA', 'HONORARIOS'],
      required: true,
      defaultsTo: 'HONORARIOS'
    },
    rfc: {
      type: 'String',
      required: true,
      unique: true
    },
    curp: {
      type: 'String'
    },
    nss: {
      type: 'String'
    },
    fecha_nacimiento: {
      type: 'Date'
    },
    sexo: {
      type: 'String',
      enum: ['HOMBRE', 'MUJER'],
      required: true
    },
    nombre: {
      type: 'String',
      required: true
    },
    primer_apellido: {
      type: 'String',
      required: true
    },
    segundo_apellido: {
      type: 'String'
    },
    correo_electronico: {
      type: 'String'
    },
    tipo_pago: {
      type: 'String',
      enum: ['DEPOSITO', 'CHEQUE'],
      required: true,
      defaultsTo: 'CHEQUE'
    },
    banco: {
      type: 'String',
      enum: ['BANCOMER', 'BANAMEX', 'HSBC'],
    },
    numero_cuenta: {
      type: 'String'
    },
    // tipo_contrato: {
    //   type: 'String',
    //   enum: ['BASE', 'CONFIANZA', 'HONORARIOS'],
    //   required: true,
    //   defaultsTo: 'HONORARIOS'
    // },
    numero_empleado: {
      type: 'String'
    },
    status: {
      type: 'String',
      enum: ['ACTIVO', 'LICENCIA', 'BAJA'],
      required: true,
      defaultsTo: 'ACTIVO'
    },
    // adscripcion:{
    //   model: 'adscripcion'
    // }
    puesto: {
      model: 'empleado'
    }
  }
};
