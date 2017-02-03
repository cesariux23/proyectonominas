'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('TotalEmpleado service', function() {
  it('registered the TotalEmpleados service', () => {
    assert.ok(app.service('TotalEmpleados'));
  });
});
