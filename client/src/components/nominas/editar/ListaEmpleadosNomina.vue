<template>
  <div class="ListaEmpleadosNomina">
    <div class="columns">
      <div class="column">
        <h1 class="title">
          <router-link :to="{ path: '/nominas'}" class="button is-info is-outlined" title="Volver al listado de nominas">
          <span class="icon"><i class="fa fa-arrow-left"></i></span>
        </router-link>
        {{nomina.descripcion}}</h1>
        <h2 class="subtitle">{{nomina.tipo_nomina.descripcion}}</h2>
      </div>
      <div class="column is-one-quarter">
        <p class="block">
          <router-link v-if="nomina.estado=='EN_PROCESO'" :to="{ path: '/nominas/'+nomina.id+'/edit'}" class="button is-info is-outlined">
            <span class="icon">
              <i class="fa fa-list"></i>
            </span>
            <span>Ir al listado</span>
          </router-link>
          <a class="button is-primary" role="button">
            <span class="icon"><i class="fa fa-user-plus"></i></span>
               <span>Agregar empleados</span>
          </a>
        </p>
      </div>
    </div>
    <div class="box">
      <h2 class="title is-4">Resumen</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Núm. Empleados</th>
            <th>Bruto total</th>
            <th>Neto total</th>
            <th>ISR total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{numero_empleados}}</td>
            <td>{{nomina.total_percepciones}}</td>
            <td>{{nomina.total_percepciones - nomina.total_deducciones}}</td>
            <td>{{nomina.total_isr}}</td>
          </tr>
        </tbody>
      </table>
      Finalizar proceso
    </div>
    <div class="box">
      <h3 class="title is-4">Empleados</h3>
        <table class="table">
          <thead>
            <th>#</th>
            <th>RFC</th>
            <th>Empleado</th>
            <th>Total Perceciones</th>
            <th>Total Deducciones</th>
            <th>ISR</th>
            <th><i class="fa fa-cog"></i> Acciones</th>
          </thead>
          <thead>
            <tr v-for="(e, index) in nomina.empleados">
              <td>
                {{index+1}}
                <span>{{getDatosPersonales(e)}}</span>
              </td>

              <td v-if="e._empleado">{{e._empleado.rfc}}</td>
              <td v-if="e._empleado">
                {{e._empleado.nombre_completo}}
                <br>
                {{e._empleado.puesto.puesto}}
              </td>
              <td>{{e.total_percepciones}}</td>
              <td>{{e.total_deducciones}}</td>
              <td>{{e.total_isr}}</td>
              <td>
                <router-link :to="{ path: 'edit/desglose/'+e.id }" class="button is-info is-outlined" title="Editar detalle del empleado">
                  <span class="icon"><i class="fa fa-pencil"></i></span>
                </router-link>
              </td>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ListaEmpleadosNomina',
  data () {
    return {
      nomina: {
        tipo_nomina: {
        },
        empleados: []
      },
      personal: []
    }
  },
  computed: {
    numero_empleados: function () {
      return this.nomina.empleados.length
    }
  },
  methods: {
    getNomina: function () {
      var self = this
      this.$io.socket.get('/nomina/' + self.id, function (data) {
        self.nomina = data
      })
      this.$io.socket.on('nomina', function (data) {
        console.log('escuchando')
        console.log(data)
      })
    },
    getPersonal: function () {
      var self = this
      this.$io.socket.get('/personal', function (data) {
        self.personal = data
      })
    },
    getDatosPersonales: function (e) {
      e._empleado = this.personal.find((p) => p.id === e.datos_personales)
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina()
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
