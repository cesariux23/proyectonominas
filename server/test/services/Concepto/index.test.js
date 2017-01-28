'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('Concepto service', function() {
  it('registered the Conceptos service', () => {
    assert.ok(app.service('Conceptos'));
  });
});
