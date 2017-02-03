'use strict';

const assert = require('assert');
const getTipoNomina = require('../../../../src\services\nomina\hooks\getTipoNomina.js');

describe('nomina getTipoNomina hook', function() {
  it('hook can be used', function() {
    const mockHook = {
      type: 'before',
      app: {},
      params: {},
      result: {},
      data: {}
    };

    getTipoNomina()(mockHook);

    assert.ok(mockHook.getTipoNomina);
  });
});
