<template>
  <div class="ListaEmpleados">
    <div class="columns">
      <div class="column">
        <h1 class="title"><b>EMPLEADOS</b></h1>
      </div>
      <div class="column is-2">
        <router-link to="empleados/new" class="button is-primary">
          <span class="icon"><i class="fa fa-user-plus"></i></span>
          <span>Registrar empleado</span>
        </router-link>
      </div>
    </div>
    <hr>
    <section>
      <div class="box">
        <table class="table">
          <thead>
            <tr>
              <!-- <th><abbr title="Position">Pos</abbr></th> -->
              <th>#</th>
              <th>RFC</th>
              <th>Nombre</th>
              <th>Primer Apellido</th>
              <th>Segundo Apellido</th>
              <th>CURP</th>
              <th>Tipo de contrato</th>
              <th>Puesto</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(empleado, index) in empleados">
              <td>{{index+1}}</td>
              <td>{{empleado.rfc}}</td>
              <td>{{empleado.nombre}}</td>
              <td>{{empleado.primer_apellido}}</td>
              <td>{{empleado.segundo_apellido}}</td>
              <td>{{empleado.curp}}</td>
              <td>{{empleado.tipo_contrato}}</td>
              <td></td>
              <td>
                <router-link :to="{ path: 'empleados/'+empleado.id }" class="button is-primary is-outlined" title="Ver detalles"><i class="fa fa-user"></i></router-link>
                <router-link :to="{ path: 'empleados/'+empleado.id+'/edit' }" class="button is-info is-outlined" title="Editar información"><i class="fa fa-pencil"></i></router-link>
                <button class="button  is-danger is-outlined" title="Baja del empleado"><i class="fa fa-times"></i> </button>
              </td>

            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>

  </div>
</template>

<script>
// import { addEmpleado } from '../../vuex/actions'
// import { getPersonal } from '../../vuex/getters'
export default {
  name: 'ListaEmpleados',
  // vuex: {
  //   getters: {
  //     empleados: getPersonal
  //   },
  //   actions: {
  //     addEmpleado
  //   }
  // },
  data () {
    return {
      empleados: []
    }
  },
  methods: {
    getEmpleados: function () {
      var self = this
      this.$io.socket.get('/personal', function (data) {
        self.empleados = data
      })
    }
  },
  mounted: function () {
    this.getEmpleados()
    // this.fetchEmpleados()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
