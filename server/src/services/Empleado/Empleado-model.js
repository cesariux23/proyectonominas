'use strict';

// Empleado-model.js - A sequelize model
//
// See http://docs.sequelizejs.com/en/latest/docs/models-definition/
// for more of what you can do here.

const Sequelize = require('sequelize');

//requirimientos
const moment = require('moment');

module.exports = function(sequelize) {
  const Empleado = sequelize.define('Empleados', {
    rfc: {
      type: Sequelize.STRING,
      allowNull: false,
      unique: true
    },
    curp: {
      type: Sequelize.STRING
    },
    nss: {
      type: Sequelize.STRING
    },
    fecha_nacimiento: {
      type: Sequelize.DATE
    },
    sexo: {
      type: Sequelize.ENUM('HOMBRE', 'MUJER'),
      allowNull: false
    },
    nombre: {
      type: Sequelize.STRING,
      allowNull: false
    },
    primer_apellido: {
      type: Sequelize.STRING,
      allowNull: false
    },
    segundo_apellido: {
      type: Sequelize.STRING
    },
    tipo_contrato: {
      type: Sequelize.ENUM('BASE', 'CONFIANZA', 'CONTRATO'),
      allowNull: false
    },
    numero_empleado: {
      type: Sequelize.STRING
    },
    tipo_pago: {
      type: Sequelize.ENUM('DEPOSITO', 'CHEQUE'),
      allowNull: false
    },
    banco: {
      type: Sequelize.STRING
    },
    numero_cuenta: {
      type: Sequelize.STRING
    },
    fecha_ingreso: {
      type: Sequelize.DATE,
      allowNull:false
    },
    status: {
      type: Sequelize.ENUM('ACTIVO', 'LICENCIA','BAJA'),
      allowNull: false,
      defaultValue: 'ACTIVO'
    },

  }, {
    freezeTableName: true,
    underscored: true,
    version: true,
    getterMethods   : {
      nombre_completo: function()  {
        var pa = this.getDataValue('primer_apellido');
        var sa = this.getDataValue('segundo_apellido');
        var apellidos="";
        if(pa != null)
          apellidos=pa;
          if(sa !=null){
            if(apellidos != "")
              apellidos += " ";
            apellidos += sa;
          }
          return apellidos + " " + this.getDataValue('nombre');
      },
      edad: function () {
        var fn = this.getDataValue('fecha_nacimiento');
        if(fn != null){
          return moment().diff(fn, 'years');
        }
        else {
          return null;
        }
      },
      antiguedad_absoluta: function () {
        var fi = this.getDataValue('fecha_ingreso');
        if(fi != null){
          var ant=[]
          var hoy=moment();
          var a=hoy.diff(fi, 'years');
          hoy.subtract(a, 'years');
          var m=hoy.diff(fi, 'months');
          hoy.subtract(m, 'months');
          var d=hoy.diff(fi, 'days');

          ant.push(a);
          ant.push(m);
          ant.push(d);
          return ant;
        }
        else {
          return null;
        }
      }
    },
  });

  Empleado.sync();

  return Empleado;
};
