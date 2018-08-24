<template lang="pug">
  .ListaNominas
    .columns
      .column
        h1.title Nóminas
      .column.is-right
        router-link.button.is-primary(:to="{name: 'nuevoProceso'}")
          span.icon
            i.fa.fa-plus
          span Nuevo proceso de nómina
    .box
      h3.title Procesos activos
      table.table
        thead
          tr
            th #
            th Ejercicio
            th Periódo
            th Descripción
            th Emisión
            th Status
            th(title='Acciones')
              i.fa.fa-cog
        tbody(v-if='procesos.length')
          tr(v-for='(proceso, index) in procesos', v-if="proceso.status=='EN PROCESO'", :key='proceso.id')
            td {{index+1}}
            td {{proceso.nomina.ejercicio}}
            td
              | {{proceso.nomina.periodo}}
              br
              | {{proceso.nomina.periodicidad}}
            td
              | {{proceso.nomina.descripcion}}
              br
              span(v-if='proceso.nomina.tipo_nomina')
                | {{proceso.nomina.tipo_nomina.descripcion}}
            td {{proceso.nomina.tipo_emision}}
            td {{proceso.nomina.status}}
            td
              router-link.button.is-info.is-outlined(v-if="proceso.status=='EN PROCESO'", :to="{ name: 'editarProceso', params:{id: proceso.id}}", title='Continuar')
                span.icon
                  i.fa.fa-pencil
              a.button(v-if="proceso.status=='PENDIENTE_PAGO'", href='#')  Marcar como pagada
              a.button(v-if="proceso.status!='PROCESO'", href='#')  Reportes
    .box
      h3.title Historial
      table.table
        thead
          tr
            th #
            th Periodicidad
            th Descripción
            th Tipo
            th Status
            th(title='Acciones')
              i.fa.fa-cog
        tbody
          tr(v-for='(proceso, index) in procesos', v-if="proceso.status!='EN_PROCESO'", :key='proceso.id')
            td {{index+1}}
            td
              | {{proceso.nomina.periodo}}
              br
              | {{proceso.nomina.periodicidad}
            td {{proceso.nomina.descripcion}}
            td
              | {{proceso.nomina.tipo_nomina.descripcion}}
              br
              | {{proceso.nomina.tipo_emision}}
            td {{proceso.nomina.status}}
            td
              a.button(v-if="proceso.nomina.status=='EN_PROCESO'", href='#')  Continuar
              a.button(v-if="proceso.nomina.status=='PENDIENTE_PAGO'", href='#')  Marcar como pagada
              a.button(v-if="proceso.nomina.status!='PROCESO'", href='#')  Reportes
    // modal para crear la nueva nomina
    .modal(:class="{'is-active' : modal}")
      .modal-background
      footer.modal-card-foot
        button.button.is-primary(type='submit')
          span.icon
            i.fa.fa-check
          span Crear nuevo proceso
        a.button(role='button') Cancelar
</template>

<script>
import { Quincena } from '../../utils/Quincena'
import { mapState, mapActions } from 'vuex'
export default {
  name: 'ListaProcesos',
  data () {
    return {
      catalogo: [],
      tipo_nomina: {},
      modal: false,
      habilita_periodo_fin: false,
      cargar_fijos: true,
      quincenaActual: Quincena.quincenaActual()
    }
  },
  methods: {
    ...mapActions({
      fetchProcesos: 'procesos/fetchProcesos'
    })
  },
  computed: {
    ...mapState('procesos', {
      procesos: state => state.procesos
    })
  },
  mounted () {
    this.fetchProcesos()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
