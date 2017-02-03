'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('Adscripcion service', function() {
  it('registered the Adscripcions service', () => {
    assert.ok(app.service('Adscripcions'));
  });
});
