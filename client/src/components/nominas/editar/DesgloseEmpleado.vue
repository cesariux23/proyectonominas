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
    <div class="columns">
      <div class="column">
        <panel-conceptos titulo="PERCEPCIONES" :conceptos="tipoConcepto('PERCEPCION')" :total="empleado.total_percepciones" tipo="PERCEPCION" @mostrarModal="mostrarModal" @getEmpleado="getEmpleado"></panel-conceptos>
      </div>
      <div class="column">
        <panel-conceptos titulo="DEDUCCIONES" :conceptos="tipoConcepto('DEDUCCION')" :total="empleado.total_deducciones" tipo="DEDUCCION" @mostrarModal="mostrarModal" @getEmpleado="getEmpleado"></panel-conceptos>
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

    <div class="modal" :class="{ 'is-active': modal }">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title"> AGREGAR <b>{{titulo_modal}}</b></p>
          <button class="delete" @click="modal=false"></button>
        </header>
        <section class="modal-card-body">
          <form>
            <label class="label">Clave</label>
            <p class="select">
              <select v-model="concepto" @change="cambiaConcepto()">
                <option v-for="c in filtraConceptos()" :value="c">{{c.clave}}</option>
              </select>
            </p>
            <div class="columns">
              <div class="column">
                <label class="label">Descripción</label>
                <p class="control">
                  <input type="text" class="input" v-model="nuevo.descripcion">
                </p>
              </div>
              <div class="column">
                <label class="label">Monto</label>
                <p class="control">
                  <input type="text" class="input" v-model="nuevo.monto">
                </p>
              </div>
            </div>
            {{nuevo}}
          </form>
        </section>
        <footer class="modal-card-foot">
          <a class="button is-success" role="button" @click="guardarConcepto()" :disabled="!guardar">
            <span class="icon">
              <i class="fa fa-check"></i>
            </span>
            <span>Agregar concepto</span>
          </a>
          <a class="button" role="button" @click="modal=false">Cancelar</a>
        </footer>
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
      modal: false,
      guardar: false,
      titulo_modal: '',
      conceptos: [],
      concepto: {},
      nuevo: {}
    }
  },
  watch: {
    modal: function (val) {
      if (!val) {
        this.concepto = {}
        this.nuevo = {}
      }
    },
    'nuevo.monto': function (val) {
      this.guardar = false
      if (val > 0) {
        this.guardar = true
      }
    }
  },
  methods: {
    cambiaConcepto: function () {
      console.log(this.concepto)
      if (this.concepto) {
        this.nuevo = {
          empleado: this.id_empleado,
          clave: this.concepto.clave,
          tipo_concepto: this.tipo_concepto,
          descripcion: this.concepto.descripcion_general,
          monto: this.concepto.monto_inicial

        }
      }
    },
    guardarConcepto: function () {
      var self = this
      this.$io.socket.post('/conceptonomina', this.nuevo, (data) => {
        if (data.err) {
          console.error(data)
        } else {
          self.modal = false
          self.getEmpleado()
        }
      })
    },
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
    getCatalogoConceptos: function () {
      var self = this
      this.$io.socket.get('/catalogoconcepto', function (data) {
        self.conceptos = data
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
    },
    mostrarModal: function (arg) {
      if (arg === 'PERCEPCION') {
        this.titulo_modal = 'PERCEPCIÓN'
      } else {
        this.titulo_modal = 'DEDUCCIÓN'
      }
      this.tipo_concepto = arg
      this.modal = true
    },
    filtraConceptos: function () {
      var self = this
      return this.conceptos.filter((c) => {
        return c.tipo_concepto === self.tipo_concepto
      })
    }
  },
  mounted: function () {
    this.id_empleado = this.$route.params.empleado
    console.log(this.id_empleado)
    this.getEmpleado()
    this.getCatalogoConceptos()
    this.subscribeEmpleado()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
