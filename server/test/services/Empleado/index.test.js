'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('Empleado service', function() {
  it('registered the Empleados service', () => {
    assert.ok(app.service('Empleados'));
  });
});
