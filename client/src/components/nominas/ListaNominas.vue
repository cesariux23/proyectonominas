<template lang="pug">
  .ListaNominas
    .columns
      .column
        h1.title Nóminas
      .column.is-right
        router-link.button.is-primary(:to="{name: 'nuevaNomina'}")
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
        tbody(v-if='nominas.length')
          tr(v-for='(nomina, index) in nominas', v-if="nomina.status=='EN_PROCESO'", :key='nomina.id')
            td {{index+1}}
            td {{nomina.ejercicio}}
            td
              | {{nomina.periodo}}
              br
              | {{nomina.periodicidad}}
            td
              | {{nomina.descripcion}}
              br
              span(v-if='nomina.tipo_nomina')
                | {{nomina.tipo_nomina.descripcion}}
            td {{nomina.tipo_emision}}
            td {{nomina.status}}
            td
              router-link.button.is-info.is-outlined(v-if="nomina.status=='EN_PROCESO'", :to="{ name: 'editarNomina', params:{id: nomina.id}}", title='Continuar')
                span.icon
                  i.fa.fa-pencil
              a.button(v-if="nomina.status=='PENDIENTE_PAGO'", href='#')  Marcar como pagada
              a.button(v-if="nomina.status!='PROCESO'", href='#')  Reportes
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
          tr(v-for='(nomina, index) in nominas', v-if="nomina.status!='EN_PROCESO'", :key='nomina.id')
            td {{index+1}}
            td
              | {{nomina.periodo}}
              br
              | {{nomina.periodicidad}
            td {{nomina.descripcion}}
            td
              | {{nomina.tipo_nomina.descripcion}}
              br
              | {{nomina.tipo_emision}}
            td {{nomina.status}}
            td
              a.button(v-if="nomina.status=='EN_PROCESO'", href='#')  Continuar
              a.button(v-if="nomina.status=='PENDIENTE_PAGO'", href='#')  Marcar como pagada
              a.button(v-if="nomina.status!='PROCESO'", href='#')  Reportes
    // modal para crear la nueva nomina
    .modal(:class="{'is-active' : modal}")
      .modal-background
      footer.modal-card-foot
        button.button.is-primary(type='submit')
          span.icon
            i.fa.fa-check
          span Crear nomina
        a.button(role='button') Cancelar
</template>

<script>
import { Quincena } from '../../utils/Quincena'
import { mapState, mapActions } from 'vuex'
export default {
  name: 'ListaNominas',
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
      fetchNominas: 'nominas/fetchNominas'
    })
  },
  computed: {
    ...mapState('nominas', {
      nominas: state => state.nominas
    })
  },
  mounted () {
    this.fetchNominas()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
