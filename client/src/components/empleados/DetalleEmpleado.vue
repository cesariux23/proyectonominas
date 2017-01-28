<template>
  <div class="DetalleEmpleado">
    <div class="box">
        <header>
          <h1 class="title is-4">{{empleado.nombre}} {{empleado.primer_apellido}} {{empleado.segundo_apellido}}</h1>
          <h2 class="subtitle">{{empleado.rfc}}</h2>
        </header>
        <hr>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DetalleEmpleado',
  data () {
    return {
      empleado: {}
    }
  },
  methods: {
    getEmpleado: function () {
      var self = this
      this.$http.get('empleados/' + self.id, {})
    .then(function (response) {
      console.log(response.data)
      self.empleado = response.data
    })
    .catch(function (error) {
      console.log(error)
    })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getEmpleado()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
