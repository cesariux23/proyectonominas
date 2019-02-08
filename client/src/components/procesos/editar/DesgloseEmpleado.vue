<template lang="pug">
  .DesgloseEmpleado
    modal-agregar-concepto(:show="modal" :tipo="tipo_concepto" @close="close" :desglose="idDesglose")
    encabezado-nomina(:nomina = 'nomina')
    .box(v-if='empleado')
      h5.title.is-5.border-bottom(v-if='empleado') {{empleado.datos_personales.nombre_completo}}
      b RFC:
      |  {{empleado.datos_personales.rfc}}
      | / 
      b Adscripción:
      |  {{empleado.puesto_actual.adscripcion.nombre}}
      | /  
      b Puesto:
      |  {{empleado.puesto_actual.plaza.nombre}}

    .columns
      .column
        panel-conceptos(titulo='Percepciones' :conceptos="desglose.percepciones" tipo='PERCEPCION' :desglose="idDesglose" @mostrarmodal='mostrarmodal' @eliminarconcepto='eliminarConcepto')
      .column
        panel-conceptos(titulo='Deducciones' :conceptos="desglose.deducciones" tipo='DEDUCCION' :desglose="idDesglose" @mostrarmodal='mostrarmodal' @eliminarconcepto='eliminarConcepto')
    section#resumen.box
      h5.title.is-4.border-bottom Resumen
      table.table
        tbody
          tr
            th Subtotal
            th Percepción excenta
            th ISR
            th Percepción neta
          tr
            td $ {{subtotal}}
            td $ {{desglose.total_excento_percepciones}}
            td $ {{isr}}
            td
              b $ {{desglose.total_neto}}
</template>

<script>
import PanelConceptos from './partials/PanelConceptos'
import ModalAgregarConcepto from './partials/ModalAgregarConcepto'
import { mapGetters, mapState, mapActions } from 'vuex'
import EncabezadoNomina from '../Encabezado'
export default {
  name: 'DesgloseEmpleado',
  components: {
    PanelConceptos,
    ModalAgregarConcepto,
    EncabezadoNomina
  },
  data () {
    return {
      modal: false,
      guardar: false,
      tipo_concepto: '',
      idProceso: 0,
      idDesglose: 0,
      x: 0,
      nomina: {}
    }
  },
  computed: {
    isr: function () {
      return this.desglose.total_isr
    },
    empleado () {
      return this.desglose.empleado ? this.desglose.empleado : false
    },
    desglose () {
      return this.getDesgloseById(this.idDesglose) || {}
    },
    subtotal: function () {
      return (this.desglose.total_percepciones - this.desglose.total_deducciones).toFixed(2)
    },
    ...mapGetters({
      getNominaById: 'nominas/getNominaById',
      getDesgloseById: 'desgloseNomina/getDesgloseById'
    }),
    ...mapState(['catalogos'])
  },
  watch: {
    'empleado.conceptos': function (val) {
      console.log('cambia conceptos')
      this.$set(this.desglose, 'total_isr', this.desglose.total_isr)
    }
  },
  methods: {
    ...mapActions({
      getDesglose: 'desgloseNomina/getDesglose'
    }),
    close () {
      this.modal = false
    },
    actualizaConcepto: function (c) {
      var self = this
      this.$io.socket.put('/conceptonomina/' + c.id, c, (data) => {
        if (data.err) {
          console.error(data)
        } else {
          self.getEmpleado()
        }
      })
    },
    guardarConcepto: function () {
      var self = this
      this.$io.socket.post('/conceptonomina', this.nuevo, (data) => {
        if (data.err) {
          console.error(data)
        } else {
          self.getEmpleado()
        }
      })
    },
    getEmpleado: function () {
      var self = this
      setTimeout(function () {
        self.$io.socket.get('/empleadonomina', {'id': self.id_empleado}, function (data) {
          self.empleado = data
          self.modal = false
        })
      }, 200)
      this.subscribeEmpleado()
    },
    eliminarConcepto: function (id) {
      var self = this
      this.$io.socket.delete('/conceptonomina/' + id, (data) => {
        if (data.error) {
          console.error(data)
          window.alert('Error al eliminar el concepto: ' + id)
        }
        self.getEmpleado()
      })
    },
    // eliminarConcepto: function (e) {
    //   this.empleado.conceptos.splice(this.empleado.conceptos.indexOf(e), 1)
    // },
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
    mostrarmodal: function (arg) {
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
    this.idDesglose = this.$route.params.iddesglose
    this.x = String(this.idDesglose)
    this.idProceso = this.$route.params.id
    this.nomina = this.getNominaById(this.idProceso)
    this.getDesglose([this.idProceso, this.idDesglose])
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.border-bottom {
  padding-bottom: 5px;
  margin-bottom: 5px !important;
  border-bottom: 1px #dbdbdb solid;
}
</style>
