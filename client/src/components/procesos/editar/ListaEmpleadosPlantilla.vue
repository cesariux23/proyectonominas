<template lang="pug">
  .ListaEmpleadosNomina
    .columns(v-if="proceso")
      .column
        router-link.button.is-info.is-outlined(:to="{ path: '/proceso'}", title='Volver al listado de procesos')
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
    .box(v-if="nomina")
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
            td {{plantilla.total_empleados}}
            td {{plantilla.total_percepciones}}
            td {{plantilla.total_deducciones}}
            td {{plantilla.total_neto}}
            td {{plantilla.total_isr}}
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
    .box(v-if="nomina")
      .columns
        .column
          h3.title.is-4 Empleados
        .column.is-right
          router-link.button.is-info.is-outlined(:to={name: 'agregarEmpleados'})
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
          tr(v-for='(e, index) in plantilla.desglose', :key='e.id')
            td
              | {{index+1}}
            td(v-if='e.empleado') {{e.empleado.datos_personales.rfc}}
            td(v-if='e.empleado')
              | {{e.empleado.datos_personales.nombre_completo}}
              br
              | {{e.empleado.puesto_actual.adscripcion.nombre}}
            td {{e.total_percepciones}}
            td {{e.total_deducciones}}
            td {{e.total_isr}}
            td {{e.total_neto}}
            td
              router-link.button(:to="{ name:'editarDesgloseEmpleado', params: {iddesglose: e.id} }", title='Editar detalle del empleado')
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
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'ListaEmpleadosNomina',
  data () {
    return {
      id: null,
      showEmpleadoModal: false,
      onlyActivos: true,
      columns: [
        {
          label: 'Empleado'
        },
        {
          label: 'Adscripcion'
        }
      ]
    }
  },
  computed: {
    ...mapGetters({
      getProcesoById: 'procesos/getProcesoById'
    }),
    proceso () {
      return this.getProcesoById(this.id)
    },
    nomina () {
      return this.proceso ? this.proceso.nomina : null
    },
    plantilla () {
      return this.proceso ? this.proceso.plantilla : null
    }
  },
  methods: {
    ...mapActions({
      getProceso: 'procesos/getProceso'
    }),
    openEmpleadosModal () {
      this.showEmpleadoModal = true
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getProceso({ id: this.id })
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
