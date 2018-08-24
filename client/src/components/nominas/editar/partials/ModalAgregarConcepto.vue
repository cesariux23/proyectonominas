<template lang="pug">
  .modal(:class="{ 'is-active': show }")
    .modal-background
    .modal-card
      header.modal-card-head
        p.modal-card-title
          b AGREGAR {{titulo}}
        button.delete(@click='hide')
      section.modal-card-body
        form
          .columns
            .column.is-4
              label.label Clave
              p.select
                select(v-model='concepto', @change='cambiaConcepto()')
                  option(v-for='c in conceptos', :value='c') {{c.clave}}
            .column(v-if='concepto')
              label.label Descripción
              p.control
                | {{concepto.descripcion || ' -- Seleccione una clave --'}}
          .columns
            .column(v-if=('concepto.tipo_valor == "$"'))
              label.label Monto
              p.control.has-icon
                input.input(v-model='nuevo.valor' :disabled="!nuevo.editable" type='text')
                span.icon.is-small
                  i.fa.fa-usd
            .column(v-if=('concepto.tipo_valor == "%"'))
              label.label Porcentaje
              p.control.has-icon
                input.input(v-model='nuevo.valor' :disabled="!nuevo.editable" type='text')
                span.icon.is-small %
            .column(v-if="concepto.excento && concepto.tipo === 'PERCEPCION'")
              label Excento
                | {{nuevo.excento}}
            .column(v-if="concepto.excento && concepto.tipo === 'PERCEPCION'")
              label Grabado
      footer.modal-card-foot
        a.button.is-success(role='button', @click='guardarConcepto()', :disabled='!guardar')
          span.icon
            i.fa.fa-check
          span Agregar concepto
        a.button(role='button', @click='hide') Cancelar
</template>
<script>
import { mapState } from 'vuex'
export default {
  name: 'ModalAgregarConcepto',
  props: ['show', 'tipo'],
  data () {
    return {
      nuevo: {},
      concepto: {},
      guardar: false
    }
  },
  computed: {
    ...mapState(['catalogos']),
    conceptos () {
      if (this.tipo === 'PERCEPCION') {
        return this.catalogos.percepciones ? this.catalogos.percepciones : []
      }
      if (this.tipo === 'DEDUCCION') {
        return this.catalogos.deducciones ? this.catalogos.deducciones : []
      }
      return []
    },
    titulo () {
      return this.tipo === 'PERCEPCION' ? 'PERCEPCIÓN' : 'DEDUCCIÓN'
    }
  },
  methods: {
    hide () {
      this.$emit('close')
    },
    cambiaConcepto: function () {
      if (this.concepto) {
        this.nuevo = {
          empleado_id: this.id_empleado,
          concepto_id: this.concepto.id,
          descripcion: this.concepto.descripcion,
          valor: this.concepto.valor,
          editable: this.concepto.editable

        }
      }
    }
  },
  watch: {
    show: function (val) {
      if (!val) {
        this.concepto = {}
        this.nuevo = {}
      }
    },
    'nuevo.valor': function (val) {
      this.guardar = false
      if (val > 0) {
        this.guardar = true
      }
    }
  }
}
</script>

