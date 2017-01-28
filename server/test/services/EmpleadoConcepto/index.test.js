'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('EmpleadoConcepto service', function() {
  it('registered the EmpleadoConceptos service', () => {
    assert.ok(app.service('EmpleadoConceptos'));
  });
});
