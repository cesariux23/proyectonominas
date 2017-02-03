'use strict';

const assert = require('assert');
const cargaEmpleadosNomina = require('../../../../src\services\nomina\hooks\cargaEmpleadosNomina.js');

describe('nomina cargaEmpleadosNomina hook', function() {
  it('hook can be used', function() {
    const mockHook = {
      type: 'after',
      app: {},
      params: {},
      result: {},
      data: {}
    };

    cargaEmpleadosNomina()(mockHook);

    assert.ok(mockHook.cargaEmpleadosNomina);
  });
});
