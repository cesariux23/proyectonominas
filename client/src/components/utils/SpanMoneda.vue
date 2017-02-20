<template lang="html">
  <div class="SpanMoneda">
    $ {{valorformateado}}
  </div>

</template>

<script>
export default {
  name: 'SpanMoneda',
  props: ['valor'],
  computed: {
    valorformateado: function () {
      var _valor = '---'
      if (this.valor) {
        if (Number.isInteger(this.valor)) {
          _valor = this.valor + '.00'
        } else {
          var _v = Number.parseFloat(this.valor)
          if (isNaN(_v)) {
            _valor = 'ND'
          } else {
            _valor = _v.toFixed(2)
          }
        }
      }
      return _valor
    }
  }
}
</script>

<style lang="css">
</style>
