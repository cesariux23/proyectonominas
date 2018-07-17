<template lang="pug">
  .DetalleNomina
    .columns
      .column
        h1.title {{nomina.descripcion}}
        h3.subtitle {{nomina.tipo_nomina.descripcion}} {{nomina.periodo ? ' / ' + nomina.periodicidad + ' / ' + nomina.periodo : ''}} {{nomina.tipo_nomina.tipo_empleado ? ' / ' + nomina.tipo_nomina.tipo_empleado : ''}}
      .column.is-right(v-if="nomina.status === 'EN_PROCESO'")
        a.button.is-info(href="")
          b-icon(icon="pencil")
          span Continuar editando
</template>

<script>
import {mapActions} from 'vuex'
export default {
  name: 'DetalleNomina',
  data () {
    return {
      nomina: {
        cat_nomina: {
        }
      }
    }
  },
  methods: {
    ...mapActions(['getNomina'])
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
