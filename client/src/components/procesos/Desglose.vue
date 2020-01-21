<template>
  <div class="DesgloseProceso">
    <encabezado-nomina :nomina = 'nomina'/>
    <router-view></router-view>
  </div>
</template>

<script>
import EncabezadoNomina from './Encabezado'
import { mapGetters } from 'vuex'
export default {
  name: 'DesgloseNomina',
  data () {
    return {
      id: 0
    }
  },
  components: {
    EncabezadoNomina
  },
  computed: {
    ...mapGetters({
      getNominaById: 'nominas/getNominaById'
    }),
    nomina () {
      return this.getNominaById(this.id)
    }
  },
  mounted () {
    this.id = this.$route.params.id
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
