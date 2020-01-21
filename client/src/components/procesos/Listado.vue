<template lang="pug">
  .ListaNominas
    .columns
      .column
        h2.title.is-2.font-weight-normal Nóminas
      .column.is-right
        router-link.button.is-primary(:to="{name: 'nuevaNomina'}")
          span.icon
            i.fa.fa-plus
          span Nuevo proceso de nómina
    .box(v-if="nominas.length > 0")
      h3.title.is-3.no-margin-bottom En proceso
      ListNominas(:items='enProgreso')
    .box
      h3.title.is-3.no-margin-bottom Historial
      ListNominas(:items='historico')
</template>

<script>
import { Quincena } from '../../utils/Quincena'
import { mapState, mapActions } from 'vuex'
import ListNominas from './partials/ListTemplate'
export default {
  name: 'ListaNominas',
  components: {ListNominas},
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
    }),
    enProgreso () {
      return this.nominas.filter(i => i.status === 'EN PROCESO')
    },
    historico () {
      return this.nominas.filter(i => i.status !== 'EN PROCESO')
    }
  },
  mounted () {
    this.fetchNominas()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
</style>
