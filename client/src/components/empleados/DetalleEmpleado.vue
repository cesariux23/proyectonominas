<template>
  <div class="DetalleEmpleado">
    <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined is-medium" title="Volver al listado de empleados">
      <span class="icon"><i class="fa fa-arrow-left"></i></span>
    </router-link>
    <h1 class="title is-inline">
      <b>Datos del empleado</b>
    </h1>
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
      this.$io.socket.get('/personal/' + self.id, function (data) {
        self.empleado = data
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
