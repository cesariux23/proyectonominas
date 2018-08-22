<template lang="pug">
  .CatalogoConceptos
    .columns
      .column
        h3.title
          | CATÁLOGO DE CONCEPTOS DE NÓMINA
      .column.is-right
        button.button.is-primary(type='button')
          span.icon
            i.fa.fa-plus
          span
            | Agregar
    .columns
      .column
        .box
          h4.title.is-4 Percepciones
          table.table
            thead
              tr
                th #
                th Clave
                th(colspan='2') Descripción
                th(colspan='2') Valor inicial
                th
                  | Exento
                th(title='Fijable')
                  span.icon
                    i.fa.fa-thumb-tack
                th
                  span.icon
                    i.fa.fa-cog
            tbody
              tr(v-for='(c, index) in percepciones')
                th {{index +1 }}
                td {{c.clave}}
                td {{c.descripcion}}
                td
                  i.fa.fa-pencil(v-if='c.descripcion_editable')
                td
                  span(v-if='c.porcentaje')
                    | {{c.porcentaje}}
                    | %
                  span-moneda(v-if='c.monto', :valor='c.monto_inicial')
                td
                  i.fa.fa-pencil(v-if='c.editable')
                td
                  span.icon(v-if='c.excento == 100')
                    i.fa.fa-check
                td
                  span.icon(v-if='c.fijable')
                    i.fa.fa-check
                td
                  button.button.is-info.is-outlined(type='button')
                    span.icon
                      i.fa.fa-edit
                  button.button.is-danger.is-outlined(type='button')
                    span.icon
                      i.fa.fa-times
      .column
        .box
          h4.title.is-4 Deducciones
          table.table
            thead
              tr
                th #
                th Clave
                th(colspan='2') Descripción
                th(colspan='2') Valor inicial
                th(colspan='2') Editable
                th
                  | Exento
                th(title='Fijable')
                  span.icon
                    i.fa.fa-thumb-tack
                th
                  span.icon
                    i.fa.fa-cog
            tbody
              tr(v-for='(c, index) in deducciones')
                th {{index +1 }}
                td {{c.clave}}
                td {{c.descripcion}}
                td
                  i.fa.fa-pencil(v-if='c.editable')
                td
                  span(v-if='c.porcentaje')
                    | {{c.porcentaje}}
                    | %
                  span-moneda(:valor='c.monto')
                td
                  i.fa.fa-pencil(v-if='c.editable')
                td
                  span.icon(v-if='c.excento == 100')
                    i.fa.fa-check
                td
                  span.icon(v-if='c.fijable')
                    i.fa.fa-check
                td
                  button.button.is-info.is-outlined(type='button')
                    span.icon
                      i.fa.fa-edit
                  button.button.is-danger.is-outlined(type='button')
                    span.icon
                      i.fa.fa-times

</template>

<script>
import SpanMoneda from '../../components/utils/SpanMoneda'
import { mapState } from 'vuex'
export default {
  name: 'CatalogoConceptos',
  components: {
    'span-moneda': SpanMoneda
  },
  data () {
    return {
    }
  },
  computed: {
    ...mapState([
      'catalogos'
    ]),
    percepciones () {
      return this.catalogos ? this.catalogos.percepciones : false
    },
    deducciones () {
      return this.catalogos ? this.catalogos.deducciones : false
    }

  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
td > i.fa{
  vertical-align: middle;
  font-size: 21px;
  color: #ddd;
}
</style>
