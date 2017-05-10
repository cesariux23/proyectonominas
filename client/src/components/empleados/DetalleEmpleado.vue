<template>
  <div class="DetalleEmpleado">
    <div class="columns">
      <div class="column">
        <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined" title="Volver al listado de empleados">
          <span class="icon"><i class="fa fa-arrow-left"></i></span>
        </router-link>
        <h1 class="title is-inline">
          Datos del empleado
        </h1>
      </div>
      <div class="column is-right">
        <button type="button" class="button is-primary">
          <span class="icon">
            <i class="fa fa-print"></i>
          </span>
          <span>Imprimir</span>
        </button>
      </div>
    </div>
    <div class="box">
      <header class="is-underlined">
        <div class="columns">
          <div class="column">
            <h1 class="title">{{empleado.nombre_completo}}</h1>
            <h4 class="subtitle">{{empleado.rfc}}</h4>
          </div>
          <div class="column is-right">
            <router-link :to="{ name: 'empleadoEdit', params:{id: empleado.id}}" class="button is-danger is-outlined">
              <span class="icon"><i class="fa fa-minus-circle"></i></span>
              <span>Realizar baja</span>
            </router-link>
            <router-link :to="{ name: 'empleadoEdit', params:{id: empleado.id}}" class="button" title="Editar datos laborales">
              <span class="icon"><i class="fa fa-refresh"></i></span>
              <span>Modificar</span>
            </router-link>
          </div>
        </div>
      </header>
      <div class="columns">
        <column-dato encabezado="Núm. de empleado">{{empleado.numero_empleado}}</column-dato>
        <column-dato encabezado="Tipo de contrato">{{empleado.tipo_contrato}}</column-dato>
        <column-dato encabezado="Clave">{{empleado.tipo_contrato}}</column-dato>
        <column-dato encabezado="Puesto">{{empleado.tipo_contrato}}</column-dato>
        <column-dato encabezado="Adscripción">{{empleado.adscripcion}}</column-dato>
      </div>
    </div>
    <div class="box">
      <header class="is-underlined">
        <div class="columns">
          <div class="column">
            <h4 class="title is-4">Datos personales</h4>
          </div>
          <div class="column is-right">
            <router-link :to="{ name: 'empleadoEdit', params:{id: empleado.id}}" class="button">
              <span class="icon"><i class="fa fa-pencil"></i></span>
              <span>Editar</span>
            </router-link>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="columns">
          <column-dato encabezado="Nombre(s)">{{empleado.nombre}}</column-dato>
          <column-dato encabezado="Primer apellido">{{empleado.primer_apellido}}</column-dato>
          <column-dato encabezado="segundo apellido">{{empleado.segundo_apellido}}</column-dato>
        </div>
        <div class="columns">
          <column-dato encabezado="RFC">{{empleado.rfc}}</column-dato>
          <column-dato encabezado="CURP">{{empleado.curp}}</column-dato>
          <column-dato encabezado="Fecha de nacimiento">{{empleado.fecha_nacimiento}}</column-dato>
          <column-dato encabezado="Edad">{{empleado.edad}}</column-dato>
          <column-dato encabezado="Sexo">{{empleado.sexo}}</column-dato>
          <column-dato encabezado="NSS">{{empleado.nss}}</column-dato>
        </div>
        <div class="columns">
          <column-dato encabezado="Correo electrónico">{{empleado.correo}}</column-dato>
          <column-dato encabezado="Forma de pago">{{empleado.tipo_pago}}</column-dato>
          <column-dato encabezado="Banco">{{empleado.banco}}</column-dato>
          <column-dato encabezado="Número de cuenta bancaria">{{empleado.numero_cuenta}}</column-dato>
        </div>
      </div>
    </div>


    <div class="box">
      <header class="is-underlined">
        <div class="columns">
          <div class="column">
            <h4 class="title is-4">Historial laboral</h4>
          </div>
          <div class="column is-right">
            <router-link :to="{ name: 'empleadoEdit', params:{id: empleado.id}}" class="button">
              <span class="icon"><i class="fa fa-plus"></i></span>
              <span>Agregar</span>
            </router-link>
          </div>
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
