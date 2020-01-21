<template lang="pug">
  div
    b-table(
      :data='items'
      paginated=true
      per-page=5
      )
      template(slot-scope="props")
        b-table-column(label="ID" string)
          | {{ props.row.id }}
        b-table-column(label="Periódo" string)
          b-tooltip(:label="props.row.periodicidad" dashed)
            | {{ props.row.periodo }}
        b-table-column(label="Descripción" string)
          | {{ props.row.descripcion }}
        b-table-column(label="Tipo personal" string)
          | {{props.row.tipo_nomina.aplica.join(', ')}}
        b-table-column(label="Estatus" string)
          | {{props.row.status}}
        b-table-column(label="Acciones" string)
          .field.has-addons
            p.control
              router-link.button.is-info.is-outlined(v-if="props.row.status=='EN PROCESO'", :to="{ name: 'desgloseNomina', params:{id: props.row.id}}", title='Continuar')
                i.fa.fa-pencil
            p.control(v-if="props.row.status==='PENDIENTE DE PAGO'")
              a.button(href='#')  Marcar como pagada
            p.control(v-if="props.row.status!=='EN PROCESO'")
              a.button(href='#')  Reportes
      template(slot='empty')
        section.section
          .content.has-text-grey.has-text-centered
            i.fa.fa-archive.fa-2x
            br
            | Sin elementos
</template>
<script>
export default {
  name: 'ListTemplate',
  props: ['items']
}
</script>

