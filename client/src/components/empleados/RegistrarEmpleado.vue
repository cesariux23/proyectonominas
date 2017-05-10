<template>
  <div class="RegistrarEmpleado">
    <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined" title="Volver al listado de empleados">
      <span class="icon"><i class="fa fa-arrow-left"></i></span>
    </router-link>
    <h1 class="title is-inline">
      Alta de empleado
    </h1>

    <div class="box">
        <form v-on:submit.prevent="guardar">
          <formulario-empleado :personal='personal' :empleado="empleado"></formulario-empleado>
          <hr>
          <button type="submit" name="button" class="button is-primary" v-on:click="guardar">
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
import Router from '../../router'
import { Quincena } from '../../utils/Quincena'
export default {
  name: 'RegistrarEmpleado',
  components: {
    FormularioEmpleado,
    Quincena
  },
  data () {
    return {
      personal: {
      },
      empleado: {
        fecha_inicio: Quincena.quincenaActual().inicio.toDate()
      },
      url: ''
    }
  },
  // vuex: {
  //   // getters: {
  //   //   empleados: getPersonal
  //   // },
  //   actions: {
  //     addPersonal
  //   }
  // },
  methods: {
    guardar () {
      var self = this
      this.$io.socket.post('/personal', self.personal, function (data) {
        if (data.error) {
          console.error(data)
          return
        }
        self.empleado.datos_personales = data.id
        // se almacena el puesto del empleado nuevo
        self.$io.socket.post('/empleado', self.empleado, function (emp) {
          if (emp.error) {
            console.error(emp)
            return
          }
          Router.push('/empleados/' + data.id)
        })
      })
    }
  },
  mounted: function () {
    this.url = this.$baseURL + '/empleados/'
    this.personal = {}
    console.log(Quincena.quincenaActual().inicio)
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
