<template lang="pug">
  .DatosPersonalesDetail(v-if="data")
    header.is-underlined
      .columns
        .column
          h4.title.is-4 {{details.title}}
        .column.is-right
          router-link.button(:to="{ name: 'empleadoEdit', params:{id: id, partial: details.partial}}")
            span.icon
                i.fa.fa-pencil
            span Editar
          
    .content
      .columns
      .columns(v-for="row in details.rows")
        column-dato(v-for="item in row" :encabezado="item.header" :key="item.field") {{getValue(item.field)}}
</template>
<script>
import ColumnDato from '@/components/utils/ColumnDato'
export default {
  name: 'EmpleadoDetails',
  props: ['id', 'data', 'details'],
  components: {
    ColumnDato
  },
  data () {
    return {
    }
  },
  methods: {
    getValue (field) {
      if (field.includes('.')) {
        const keys = field.split('.')
        return this.data[keys[0]] ? this.data[keys[0]][keys[1]] : ''
      } else {
        return this.data[field]
      }
    }
  }
}
</script>

