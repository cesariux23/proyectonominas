<template>
  <div class="ListaEmpleadosNomina">
    <h2 class="title is-4">Resumen</h2>
    <div class="box">
      <table class="table">
        <thead>
          <tr>
            <th>Empleados</th>
            <th>Bruto total</th>
            <th>Neto total</th>
            <th>ISR total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>1.1</td>
            <td>1.0</td>
            <td>0.1</td>
          </tr>
        </tbody>
      </table>
      Finalizar proceso
    </div>
    <h3 class="title is-4">Empleados</h3>
    <div class="box">
        <table class="table">
          <thead>
            <th>#</th>
            <th>RFC</th>
            <th>Empleado</th>
            <th>Adscripción</th>
            <th>Total Perceciones</th>
            <th>Total Deducciones</th>
            <th><i class="fa fa-cog"></i> Acciones</th>
          </thead>
          <thead>
            <tr v-for="(e, index) in nomina.empleados">
              <td>{{index+1}}</td>
              <td>{{e.empleado.rfc}}</td>
              <td>{{e.empleado.nombreCompleto}}</td>
              <td>ADS</td>
              <td>$</td>
              <td>$</td>
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
        cat_nomina: {
        },
        empleados: []
      }
    }
  },
  methods: {
    getNomina: function () {
      var self = this
      this.$http.get('nominas/' + self.id, {})
    .then(function (response) {
      self.nomina = response.data
    })
    .catch(function (error) {
      console.log(error)
    })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
