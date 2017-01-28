'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('Nomina service', function() {
  it('registered the Nominas service', () => {
    assert.ok(app.service('Nominas'));
  });
});
