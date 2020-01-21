<template lang="pug">
.columns(v-if="nomina")
  .column.is-four-fifths
    router-link(:to="route", title='Volver al listado de empleados')
       b-icon(icon="arrow-circle-o-left" size="is-large" type="is-info")
    div(style='display: inline-block;')
      h1.title
        | {{nomina.descripcion}}
    h2.subtitle(v-if="nomina.tipo_nomina") {{nomina.tipo_nomina.descripcion}}
  .column.is-right
    button.button.is-primary(type='button' v-if="finalize")
      span.icon
        i.fa.fa-check-circle-o
      span
        | Finalizar proceso
    
</template>
<script>
export default {
  name: 'EncabezadoNomina',
  props: ['nomina'],
  computed: {
    route () {
      if (this.$route.name === 'desgloseNomina') {
        return { name: 'listNomina' }
      }
      return { name: 'desgloseNomina', params: { id: this.nomina.id } }
    },
    finalize () {
      return this.$route.name === 'desgloseNomina'
    }
  }
}
</script>

