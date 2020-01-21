<template lang="pug">
  #Configuracion
    .columns
      .column
        h3.title.is-3 Configuración
      .column.is-right
        button.button.is-success.is-outlined(@click.prevent="guardar")
          span.icon
            b-icon(icon="save")
          span Guardar configuración
    hr
    configurar-nomina(:config.sync="nomina.configuracion"  :tipo="nomina.tipo_nomina" :conceptos.sync="nomina.conceptos")
</template>
<script>
import { mapState, mapActions, mapGetters } from 'vuex'
import ConfigurarNomina from '../partials/Configuracion'
import EventBus from '@/utils/EventBus'
export default {
  name: 'Configuracion',
  components: {
    ConfigurarNomina
  },
  data () {
    return {}
  },
  computed: {
    ...mapState([
      'catalogos'
    ]),
    ...mapGetters({
      getNominaById: 'nominas/getNominaById'
    }),
    nomina () {
      return this.getNominaById(this.id) || {configuracion: {}, conceptos: {}}
    }
  },
  methods: {
    ...mapActions({
      getNomina: 'nominas/getNomina',
      updateNomina: 'nominas/updateNomina'
    }),
    guardar () {
      const data = {
        id: this.id,
        nomina: {
          configuracion: this.nomina.configuracion,
          conceptos: this.nomina.conceptos
        }
      }
      this.updateNomina(data).then((respose) => {
        this.$toast.open({
          duration: 5000,
          message: 'Configuración guardada correctamente.',
          position: 'is-bottom-right',
          type: 'is-success'
        })
        this.$router.push({ name: 'desgloseNomina', params: { id: respose.id } })
      }, (error) => {
        this.$toast.open({
          duration: 5000,
          message: error.data.error,
          position: 'is-top-right',
          type: 'is-danger'
        })
      })
    }
  },
  mounted () {
    this.id = this.$route.params.id
    this.getNomina({ id: this.id })
    EventBus.$on('configuracion:sendClaves', (claves) => {
      this.claves = claves
    })
    EventBus.$emit('configuracion:requestClaves')
  }
}
</script>
