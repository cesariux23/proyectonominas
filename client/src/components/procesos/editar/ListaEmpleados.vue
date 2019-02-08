<template lang="pug">
  .ListaEmpleadosNomina
    encabezado-nomina(:nomina = 'nomina')
    .box(v-if="nomina")
      h3.title.is-3.no-margin-bottom Resumen
      table.table
        thead
          tr
            th Personas
            th Bruto total
            th Total deducciones
            th Neto total
            th ISR total
        tbody
          tr
            td {{nomina.desglose.length}}
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
           router-link.button.is-info(:to={name: 'configurarNomina'})
            span.icon
              i.fa.fa-cog
            span
              | Configuración
    .box(v-if="nomina.desglose")
      .columns
        .column
          h3.title.is-4 Desglose
        .column.is-right
          router-link.button.is-info.is-outlined(:to={name: 'agregarEmpleados'})
            span.icon
              i.fa.fa-user-plus
            span Agregar
      table.table
        thead
          th #
          th RFC
          th Empleado
          th Total Perceciones
          th Total Deducciones
          th ISR
          th Neto
          th
            i.fa.fa-flash
        thead
          tr(v-for='(e, index) in nomina.desglose', :key='e.id')
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
import EncabezadoNomina from '../Encabezado'
export default {
  name: 'ListaEmpleadosNomina',
  components: {
    EncabezadoNomina
  },
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
      getNominaById: 'nominas/getNominaById'
    }),
    nomina () {
      return this.getNominaById(this.id) || {desglose: {}, tipo_nomina: {}}
    }
  },
  methods: {
    ...mapActions({
      getNomina: 'nominas/getNomina'
    }),
    openEmpleadosModal () {
      this.showEmpleadoModal = true
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina({ id: this.id })
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
