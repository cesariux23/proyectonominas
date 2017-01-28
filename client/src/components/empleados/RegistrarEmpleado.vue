<template>
  <div class="RegistrarEmpleado">
    <div class="box">
        <header>
          <h1 class="title is-4">Nuevo empleado</h1>
        </header>
        <hr>
        <formulario-empleado v-bind:empleado='empleado'></formulario-empleado>
        <hr>
        <button type="button" name="button" class="button is-success" v-on:click="guardar()">Guardar cambios</button>
    </div>
  </div>
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
import Router from '../../router'
export default {
  name: 'RegistrarEmpleado',
  components: {
    FormularioEmpleado
  },
  data () {
    return {
      empleado: {},
      url: ''
    }
  },
  methods: {
    guardar () {
      var self = this
      this.$http.post(self.url, self.empleado)
      .then(function (response) {
        console.log(response.status)
        if (response.status === 200) {
          Router.push('/empleados/' + self.empleado.rfc)
        }
      })
    }
  },
  mounted: function () {
    this.url = this.$baseURL + '/empleados/'
    this.empleado = {}
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
