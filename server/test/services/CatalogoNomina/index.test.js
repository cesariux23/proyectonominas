'use strict';

const assert = require('assert');
const app = require('../../../src/app');

describe('CatalogoNomina service', function() {
  it('registered the CatalogoNominas service', () => {
    assert.ok(app.service('CatalogoNominas'));
  });
});
