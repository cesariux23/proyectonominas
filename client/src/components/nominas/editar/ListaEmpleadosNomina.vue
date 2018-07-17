<template lang="pug">
  .ListaEmpleadosNomina
    .columns
      .column
        router-link.button.is-info.is-outlined(:to="{ path: '/nominas'}", title='Volver al listado de empleados')
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
    .box
      h2.title.is-4 Resumen
      table.table
        thead
          tr
            th Núm. de empleados
            th Bruto total
            th Total deducciones
            th Neto total
            th ISR total
        tbody
          tr
            td {{nomina.total_empleados}}
            td {{nomina.total_percepciones}}
            td {{nomina.total_deducciones}}
            td {{nomina.total_neto}}
            td {{nomina.total_isr}}
      .columns
        .column
          button.button.is-danger.is-outlined(type='button')
            span.icon
              i.fa.fa-times
            span
              | Cancelar
        .column.is-right
          button.button.is-info(type='button')
            span.icon
              i.fa.fa-file
            span
              | Visualizar prenómina
    .box
      .columns
        .column
          h3.title.is-4 Empleados
        .column.is-right
          a.button.is-info.is-outlined(role='button' @click="openEmpleadosModal")
            span.icon
              i.fa.fa-user-plus
            span Agregar empleados
      table.table
        thead
          th #
          th RFC
          th Empleado
          th Total Perceciones
          th Total Deducciones
          th ISR
          th NETO
          th
            i.fa.fa-cog
            |  Acciones
        thead
          tr(v-for='(e, index) in nomina.empleados', :key='e.id')
            td
              | {{index+1}}
              span {{getDatosPersonales(e)}}
            td(v-if='e._empleado') {{e._empleado.rfc}}
            td(v-if='e._empleado')
              | {{e._empleado.nombre_completo}}
              br
              | {{e._empleado.puesto.puesto}}
            td {{e.total_percepciones}}
            td {{e.total_deducciones}}
            td {{e.total_isr}}
            td {{e.total_neto}}
            td
              router-link.button(:to="{ path: 'edit/desglose/'+e.id }", title='Editar detalle del empleado')
                span.icon
                  i.fa.fa-pencil
    // modal
    b-modal(:active.sync="showEmpleadoModal" has-modal-card)
      .modal-card
        .modal-card-head
          p.modal-card-title
            b-icon(icon="users")
            |  Empleados
        .modal-card-body
          .columns
            .column
              b-field
                b-input(placeholder="Buscar...")
            .column.is-4
              b-field
                b-switch(v-model="onlyActivos" true-value="solo activos" false-value="Todos") {{onlyActivos}}
          b-table(:columns="columns")
          
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'ListaEmpleadosNomina',
  data () {
    return {
      showEmpleadoModal: false,
      onlyActivos: true,
      columns: [
        {
          label: 'Empleado'
        },
        {
          label: 'Adscripcion'
        }
      ],
      nomina: {
        tipo_nomina: {
        },
        empleados: []
      }
    }
  },
  computed: {
  },
  methods: {
    ...mapActions(['getNomina']),
    openEmpleadosModal () {
      this.showEmpleadoModal = true
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina(this.id).then((response) => {
      this.nomina = response
    }, (error) => {
      this.$toast.open({
        duration: 5000,
        message: error.data.error,
        position: 'is-top-right',
        type: 'is-danger'
      })
    })
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
