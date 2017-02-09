<template>
  <div class="DesgloseEmpleado">
      <h3 class="title" v-if="empleado.nomina">
        <router-link :to="{ path: '/nominas/' + empleado.nomina.id +'/edit'}" class="button is-info is-outlined" title="Volver al listado de empleados de la nomina">
          <span class="icon"><i class="fa fa-arrow-left"></i></span>
        </router-link>
        {{empleado.nomina.descripcion}}
      </h3>
    <div class="box" v-if="empleado.datos_personales">
      <h4 class="title is-4">{{empleado.datos_personales.nombre_completo}}</h4>
      <hr>
      <div class="columns">
        <div class="column">
          <b>Puesto:</b> {{empleado.empleado.puesto}}
          <br>
          <b>Adscripción:</b> {{empleado.empleado.adscripcion}}
        </div>
        <div class="column">
          <b>RFC:</b> {{empleado.datos_personales.rfc}}
          <br>
          <b>CURP:</b> {{empleado.datos_personales.curp}}
        </div>
      </div>
    </div>
    {{modal}}
    <div class="columns">
      <div class="column">
        <panel-conceptos titulo="PERCEPCIONES" :conceptos="tipoConcepto('PERCEPCION')" :total="empleado.total_percepciones" tipo="PERCEPCION" :modal="modal"></panel-conceptos>
      </div>
      <div class="column">
        <panel-conceptos titulo="DEDUCCIONES" :conceptos="tipoConcepto('DEDUCCION')" :total="empleado.total_deducciones"></panel-conceptos>
      </div>
    </div>

    <div class="columns">
      <div class="column is-half is-offset-6">
        <div class="box">
          <table class="table">
            <tr>
              <th>SUBTOTAL</th>
              <td>$ {{empleado.total_percepciones - empleado.total_deducciones}}</td>
            </tr>
            <tr>
              <th>ISR</th>
              <td>$ {{empleado.total_isr}}</td>
            </tr>
            <tr>
              <th>
                <h4 class="title is-4">
                  <b>PERCEPCIÓN NETA</b>
                </h4>
              </th>
              <td>
                <h4 class="title is-4">
                  <b>$ {{empleado.total_neto}}</b>
                </h4>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PanelConceptos from './PanelConceptos'
export default {
  name: 'DesgloseEmpleado',
  components: {
    'panel-conceptos': PanelConceptos
  },
  data () {
    return {
      empleado: {},
      modal: false
    }
  },
  methods: {
    subscribeEmpleado: function () {
      var self = this
      this.$io.socket.on('empleadonomina', function (data) {
        console.log('escuchando empleadonomina:')
        if (data.error) {
          console.error(data)
        } else {
          if (data.id === parseInt(self.id_empleado)) {
            self.getEmpleado()
          }
        }
      })
    },
    getEmpleado: function () {
      var self = this
      this.$io.socket.get('/empleadonomina', {'id': this.id_empleado}, function (data) {
        console.log(data)
        self.empleado = data
      })
    },
    tipoConcepto: function (tipo) {
      if (this.empleado.conceptos) {
        return this.empleado.conceptos.filter(function (concepto) {
          return concepto.tipo_concepto === tipo
        })
      } else {
        return []
      }
    }
  },
  mounted: function () {
    this.id_empleado = this.$route.params.empleado
    console.log(this.id_empleado)
    this.getEmpleado()
    this.subscribeEmpleado()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
