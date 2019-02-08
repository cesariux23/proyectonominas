<template lang="pug">
.columns(v-if="nomina")
  .column.is-four-fifths
    router-link.button.is-info.is-outlined(:to="{ path: '/nomina'}", title='Volver al listado de empleados')
      span.icon
        i.fa.fa-arrow-left
    div(style='display: inline-block;')
      h1.title
        | {{nomina.descripcion}}
    h2.subtitle {{nomina.tipo_nomina.descripcion}}
  .column.is-right
    button.button.is-primary(type='button')
      span.icon
        i.fa.fa-check
      span
        | Finalizar proceso
    
</template>
<script>
export default {
  name: 'EncabezadoNomina',
  props: ['nomina']
}
</script>

