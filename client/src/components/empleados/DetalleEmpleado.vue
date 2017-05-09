<template>
  <div class="DetalleEmpleado">
    <div class="columns">
      <div class="column">
        <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined is-medium" title="Volver al listado de empleados">
          <span class="icon"><i class="fa fa-arrow-left"></i></span>
        </router-link>
        <h1 class="title is-inline">
          Datos del empleado
        </h1>
      </div>
      <div class="column">
        <router-link :to="{ name: 'empleadoEdit', params:{id: empleado.id}}" class="button is-danger is-outlined is-medium" title="Volver al listado de empleados">
          <span class="icon"><i class="fa fa-minus-circle"></i></span>
          <span>Realizar baja</span>
        </router-link>
      </div>
    </div>
    <div class="box">
      <div class="columns">
        <div class="column">
          <h1 class="title">{{empleado.nombre_completo}}</h1>
          <h4 class="subtitle">
            puesto
            <br>
            adscripcion
          </h4>
        </div>
        <div class="column">
          <div class="columns">
            <div class="column is-right">
              <span><b>RFC</b>: </span>
              <span>{{empleado.rfc}}</span>
            </div>
            <div class="column is-right">
              <span><b>Tipo de contrato</b></span>
              <h1 class="title is-5">{{empleado.tipo_contrato}}</h1>
            </div>
            <div class="column is-right">
              <span><b>Núm. de empleado</b></span>
              <h1 class="title is-5">{{empleado.numero_empleado}}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box">
      <header>
        <h4 class="title is-4">Datos personales</h4>
        <hr>
      </header>
      <div class="content">
        <div class="columns">
          <column-dato encabezado="RFC">{{empleado.rfc}}</column-dato>
          <column-dato encabezado="CURP">{{empleado.curp}}</column-dato>
          <column-dato encabezado="Fecha de nacimiento">{{empleado.fecha_nacimiento}}</column-dato>
          <column-dato encabezado="Edad">{{empleado.edad}}</column-dato>
          <column-dato encabezado="Sexo">{{empleado.sexo}}</column-dato>
          <column-dato encabezado="NSS">{{empleado.nss}}</column-dato>
        </div>
        <div class="columns">
          <column-dato encabezado="Nombre(s)">{{empleado.nombre}}</column-dato>
          <column-dato encabezado="Primer apellido">{{empleado.primer_apellido}}</column-dato>
          <column-dato encabezado="segundo apellido">{{empleado.segundo_apellido}}</column-dato>
        </div>
        <div class="columns">
          <column-dato encabezado="Forma de pago">{{empleado.tipo_pago}}</column-dato>
          <column-dato encabezado="Banco">{{empleado.banco}}</column-dato>
          <column-dato encabezado="Número de cuenta bancaria">{{empleado.numero_cuenta}}</column-dato>
        </div>
      </div>
    </div>
    <div class="box">
      <header>
        <h4 class="title is-4">Datos laborales</h4>
        <hr>
        <div class="columns">

        </div>
      </header>
    </div>
  </div>
</template>

<script>
import ColumnDato from '../utils/ColumnDato'
export default {
  name: 'DetalleEmpleado',
  components: {
    ColumnDato
  },
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
