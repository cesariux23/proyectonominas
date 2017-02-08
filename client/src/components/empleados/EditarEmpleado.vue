<template>
  <div class="EditarEmpleado">
    <div class="box">
        <header>
          <h1 class="title is-4">Editar</h1>
        </header>
        <hr>
        <form class="" :action="url" method="put">
          <formulario-empleado v-bind:empleado="empleado"></formulario-empleado>
          <hr>
          <button type="button" name="button" class="button is-success" v-on:click="guardar()">Guardar cambios</button>
        </form>
    </div>
  </div>
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
import Router from '../../router'
export default {
  name: 'EditarEmpleado',
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
    getEmpleado: function () {
      var self = this
      this.$io.socket.get('/personal/' + self.id, function (data) {
        console.log(data)
        self.empleado = data
      })
    },
    guardar () {
      var self = this
      this.$io.socket.put('/personal/' + self.id, self.empleado, function (data) {
        Router.push('/empleados/' + self.id)
      })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.url = this.$baseURL + '/empleados/' + this.id
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
