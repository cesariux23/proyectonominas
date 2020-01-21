<template lang="pug">
  .modal(:class="{ 'is-active': show }")
    .modal-background
    .modal-card
      header.modal-card-head
        p.modal-card-title
          b AGREGAR {{titulo}} {{desglose}}
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
                p.control
                  input.input(v-model='nuevo.descripcion' :disabled="!nuevo.editable" type='text')
          .columns
            .column(v-if=('concepto.tipo_valor == "$"'))
              label.label Monto
              p.control.has-icon
                input.input(v-model='nuevo.monto' :disabled="!nuevo.editable" type='text')
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
        a.button(role='button', @click='guardarConcepto', :disabled='!guardar' :class="{'is-loading': guardando, 'is-success':guardar}")          
          span.icon(v-if="!guardando")
            i.fa.fa-check
          span Agregar concepto
        a.button.is-danger(role='button', @click.prevent='hide')
          span.icon
            i.fa.fa-times
          span Cancelar
</template>
<script>
import { mapState, mapActions } from 'vuex'
import expr from 'expr-eval'
export default {
  name: 'ModalAgregarConcepto',
  props: ['show', 'tipo', 'desglose', 'values'],
  data () {
    return {
      nuevo: {},
      concepto: {},
      guardando: false,
      guardar: false
    }
  },
  computed: {
    ...mapState(['catalogos']),
    conceptos () {
      if (this.tipo === 'PERCEPCION') {
        return this.catalogos.percepciones ? this.catalogos.percepciones.filter(p => p.visible) : []
      }
      if (this.tipo === 'DEDUCCION') {
        return this.catalogos.deducciones ? this.catalogos.deducciones.filter(d => d.visible) : []
      }
      return []
    },
    titulo () {
      return this.tipo === 'PERCEPCION' ? 'PERCEPCIÓN' : 'DEDUCCIÓN'
    }
  },
  methods: {
    ...mapActions({
      agregar: 'desgloseNomina/addConcepto',
      getDesglose: 'desgloseNomina/getDesglose'
    }),
    hide () {
      this.$emit('close')
    },
    cambiaConcepto: function () {
      if (this.concepto) {
        let valor = this.concepto.valor
        const formula = this.concepto.formula
        if (typeof formula === 'string') {
          // se obtiene los parametros a evaluar donde:
          // 0: formula
          // 1: parametros
          // 2: digitos del redondeo
          const expresion = formula.split('|')
          // se obtienen los valores de los conceptos con los que se deberá evaluar
          const toEval = expresion[1].split(',')
          const params = {}
          if (toEval.length > 0) {
            this.values.forEach(v => {
              if (toEval.indexOf(v.concepto.clave) >= 0) {
                params[v.concepto.clave] = v.monto
              }
            })
            valor = Math.round(expr.Parser.evaluate(expresion[0], params), expresion[2] ? expresion[2] : 0)
          }
        }
        this.nuevo = {
          desglose_nomina_id: this.desglose,
          concepto_id: this.concepto.id,
          descripcion: this.concepto.descripcion,
          monto: valor,
          editable: this.concepto.editable
        }
        if (!this.nuevo.editable && this.nuevo.monto) {
          this.guardar = true
        } else {
          this.nuevo.editable = true
        }
      }
    },
    guardarConcepto () {
      this.guardando = !this.guardando
      this.agregar([this.desglose, this.nuevo]).then(
        (response) => {
          this.getDesglose([0, this.desglose]).then(
            (data) => { this.hide() }
          )
        },
        (error) => {
          console.log(error)
          this.hide()
        },
      )
    }
  },
  watch: {
    show (val) {
      if (!val) {
        this.concepto = {}
        this.nuevo = {}
        this.guardando = false
      }
    },
    'nuevo.monto': function (val) {
      this.guardar = false
      if (val > 0) {
        if (this.concepto.tipo === 'DEDUCCION') {
          this.nuevo.excento = val
        } else {
          this.nuevo.grabado = val
        }
        this.guardar = true
      }
    }
  },
  mounted () {
  }
}
</script>

