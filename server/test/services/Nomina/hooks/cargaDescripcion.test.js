'use strict';

const assert = require('assert');
const cargaDescripcion = require('../../../../src\services\Nomina\hooks\cargaDescripcion.js');

describe('Nomina cargaDescripcion hook', function() {
  it('hook can be used', function() {
    const mockHook = {
      type: 'after',
      app: {},
      params: {},
      result: {},
      data: {}
    };

    cargaDescripcion()(mockHook);

    assert.ok(mockHook.cargaDescripcion);
  });
});
