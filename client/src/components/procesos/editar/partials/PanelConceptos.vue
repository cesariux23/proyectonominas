<template lang="pug">
  .PanelConceptos
    .card
      header.card-header
        p.card-header-title
          | {{titulo}}
        a.card-header-icon(role='button', @click='mostrarModal()')
          span.icon
            i.fa.fa-plus
      
      .content
        table.table.is-narrow.is-bordered
          thead
            tr
              th(width="25px") #
              th Concepto
        
              th(width="50px") %
              th(width="180px") Monto
              th(width="50px")
                span.icon
                  i.fa.fa-cog
          tr(v-for='(c, index) in conceptos')
            td {{index + 1 }}
            td 
              | {{c.descripcion}}
              br
              b.has-text-grey {{c.concepto.clave}}
            td --
            td
              p.control.has-icon(:class="{'is-loading': guardando(c)}")
                input.input(placeholder='Monto', v-model='c.monto', @change='actualiza(c)', @keydown.esc="reestablece(c)" @focus='almacenaPrevio(c)', type='text', :disabled='!c.concepto.editable || guardando(c)')
                span.icon.is-small
                  i.fa.fa-usd
            td
              button.button.is-danger.is-outlined(type='button', title='Eliminar concepto', @click='eliminar(c)' tabindex='3000')
                span.icon
                  i.fa.fa-times
          tfoot
            tr
              th(colspan=3)
                | TOTAL {{titulo}}
              th(colspan=2)
                h3.title.is-5
                  b
                    span.icon
                      i.fa.fa-usd
                    | {{total}}
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'PanelConceptos',
  props: ['titulo', 'conceptos', 'tipo', 'desglose'],
  data () {
    return {
      t: 0,
      previo: {},
      saving: {}
    }
  },
  computed: {
    total: function () {
      var t = 0
      if (this.conceptos) {
        this.conceptos.forEach((c) => {
          if (c.monto) {
            t += Number.parseFloat(c.monto)
          }
        })
        this.$emit('cambiaTotal', this.tipo, t)
      }
      return t.toFixed(2)
    }
  },
  methods: {
    ...mapActions({
      update: 'desgloseProceso/updateConcepto',
      getDesglose: 'desgloseProceso/getDesglose',
      delete: 'desgloseProceso/deleteConcepto'
    }),
    mostrarModal: function () {
      this.$emit('mostrarmodal', this.tipo)
    },
    almacenaPrevio: function (c) {
      this.previo = Object.assign({}, c)
      console.log('Previo')
    },
    actualiza: function (conceptoModificado) {
      this.saving = conceptoModificado
      this.update({id: this.saving.id, data: this.saving}).then(
        (response) => {
          this.getDesglose([0, this.desglose])
          this.saving = null
        }
      )
    },
    reestablece: function (actual) {
      actual.monto = this.previo.monto
    },
    eliminar: function (concepto) {
      this.saving = concepto
      this.delete(this.saving.id).then(
        (response) => {
          this.getDesglose([0, this.desglose])
          this.saving = null
        }
      )
    },
    guardando (c) {
      return this.saving && this.saving.id === c.id
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
