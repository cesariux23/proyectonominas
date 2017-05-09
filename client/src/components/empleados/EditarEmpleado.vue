<template>
  <div class="EditarEmpleado">
    <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined is-medium" title="Volver al listado de empleados">
      <span class="icon"><i class="fa fa-arrow-left"></i></span>
    </router-link>
    <h1 class="title is-inline">
      Editar información del empleado
    </h1>
    <div class="box">
        <form class="" :action="url" method="put">
          <formulario-empleado :personal="personal" :empleado="personal.puesto"></formulario-empleado>
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
      personal: {
        puesto: {
          adscripcion: {}
        }
      },
      url: ''
    }
  },
  methods: {
    getPersonal: function () {
      var self = this
      this.$io.socket.get('/personal/' + self.id, function (data) {
        self.personal = data
      })
    },
    guardar () {
      var self = this
      this.$io.socket.put('/personal/' + self.id, self.personal, function (data) {
        Router.push('/empleados/' + self.id)
      })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.url = this.$baseURL + '/empleados/' + this.id
    this.getPersonal()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
