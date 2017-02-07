<template>
  <div class="RegistrarEmpleado">
    <div class="box">
        <header>
          <h1 class="title is-4">Nuevo empleado</h1>
        </header>
        <hr>
        <form v-on:submit.prevent="guardar">
          <formulario-empleado v-bind:empleado='empleado'></formulario-empleado>
          <hr>
          <button type="submit" name="button" class="button is-success" v-on:click="guardar">
            <span class="icon">
              <i class="fa fa-check"></i>
            </span>
            <span>
              Registrar empleado
            </span>
          </button>
        </form>
    </div>
  </div>
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
// import Router from '../../router'
import { addPersonal } from '../../vuex/actions'
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
  vuex: {
    // getters: {
    //   empleados: getPersonal
    // },
    actions: {
      addPersonal
    }
  },
  methods: {
    guardar () {
      // var self = this
      // this.$http.post(self.url, self.empleado)
      // .then(function (response) {
      //   console.log(response.status)
      //   if (response.status === 200) {
      //     Router.push('/empleados/' + self.empleado.rfc)
      //   }
      // })
      this.addPersonal(this.empleado)
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
