<template>
  <div class="RegistrarEmpleado">
    <div class="box">
        <header>
          <h1 class="title is-4">Nuevo empleado</h1>
        </header>
        <hr>
        <form v-on:submit.prevent="guardar">
          <formulario-empleado :personal='personal' :empleado="empleado"></formulario-empleado>
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
