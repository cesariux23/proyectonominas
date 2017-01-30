<template>
  <div class="DetalleNomina">
    <div class="box">
        <header>
          <h1 class="title"><b>{{nomina.periodo}}</b> -- {{nomina.descripcion}}</h1>
          <h3 class="subtitle">{{nomina.id_catalogo_nomina}}</h3>
        </header>
        <hr>
        Reportes
    </div>
  </div>
</template>

<script>
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
    getNomina: function () {
      var self = this
      this.$http.get('nominas/' + self.id, {})
    .then(function (response) {
      self.nomina = response.data
    })
    .catch(function (error) {
      console.log(error)
    })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
