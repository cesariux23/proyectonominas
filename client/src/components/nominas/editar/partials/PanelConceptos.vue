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
              th(width="100px") Clave
              th Descripción
              th(width="50px") %
              th(width="150px") Monto
              th(width="100px")
                span.icon
                  i.fa.fa-cog
          tr(v-for='(c, index) in conceptos')
            td {{index + 1 }}
            td {{c.concepto.clave}}
            td
              | {{c.concepto.descripcion}}
            td --
            td
              p.control.has-icon(v-if='c.concepto.editable')
                input.input(placeholder='Monto', v-model='c.total', @change='enviarCambios(c)', @focus='almacenaPrevio(c)', @keypress='cargarPrevio(c)', type='text')
                span.icon.is-small
                  i.fa.fa-usd
              span(v-else='')
                | {{c.total}}
            td
              button.button.is-danger.is-outlined(type='button', title='Eliminar concepto', @click='eliminar(c.id)')
                span.icon
                  i.fa.fa-times
          tfoot
            tr
              th(colspan=4)
                | TOTAL {{titulo}}
              th(colspan=2)
                h3.title.is-5
                  b $ {{total}}
</template>

<script>
export default {
  name: 'PanelConceptos',
  props: ['titulo', 'conceptos', 'tipo'],
  data () {
    return {
      t: 0,
      previo: {}
    }
  },
  computed: {
    total: function () {
      var t = 0
      if (this.conceptos) {
        this.conceptos.forEach((c) => {
          if (c.total) {
            t += Number.parseFloat(c.total)
          }
        })
        this.$emit('cambiaTotal', this.tipo, t)
      }
      return t.toFixed(2)
    }
  },
  methods: {
    mostrarModal: function () {
      this.$emit('mostrarmodal', this.tipo)
    },
    almacenaPrevio: function (c) {
      this.previo = c
    },
    enviarCambios: function (conceptoModificado) {
      this.$emit('actualizaConcepto', conceptoModificado)
    },
    cargarPrevio: function (event, actual, previo) {
      console.log(event)
    },
    eliminar: function (id) {
      this.$emit('eliminarConcepto', id)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
