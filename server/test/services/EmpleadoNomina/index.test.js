'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('EmpleadoNomina service', function() {
  it('registered the EmpleadoNominas service', () => {
    assert.ok(app.service('EmpleadoNominas'));
  });
});
