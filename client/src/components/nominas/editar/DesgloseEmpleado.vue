<template lang="pug">
  .DesgloseEmpleado
    .columns(v-if='nomina')
      .column
        router-link.button.is-info.is-outlined.is-medium(:to="{ name: 'editarNomina', params: {id: idNomina } }", title='Volver al listado de empleados de la nomina')
          span.icon
            i.fa.fa-arrow-left
        .is-inline
          h3.title(v-if='nomina')
              | {{nomina.descripcion}}
    .box(v-if='empleado')
      h5.title.is-5(v-if='empleado')
        b {{empleado.datos_personales.nombre_completo}}
      b RFC:
      |  {{empleado.datos_personales.rfc}}
      | / 
      b Adscripción:
      |  {{empleado.puesto_actual.adscripcion.nombre}}
      | /  
      b Puesto:
      |  {{empleado.puesto_actual.plaza.nombre}}

    panel-conceptos(titulo='PERCEPCIONES', :conceptos="desglose.percepciones", tipo='PERCEPCION', @mostrarmodal='mostrarmodal', @eliminarconcepto='eliminarConcepto', @actualizaconcepto='actualizaConcepto')
    panel-conceptos(titulo='DEDUCCIONES', :conceptos="desglose.deducciones", tipo='DEDUCCION', @mostrarmodal='mostrarmodal', @eliminarconcepto='eliminarConcepto')
    section#resumen.box
      h5.title.is-5
        b Resumen
      hr
      table.table
        tbody
          tr
            th SUBTOTAL
            th PERCEPCION EXCENTA
            th BASE GRABABLE
            th ISR
            th
              b PERCEPCIÓN NETA
          tr
            td $ {{subtotal}}
            td $ {{desglose.total_excento_percepciones}}
            td .
            td $ {{isr}}
            td
              b $ {{desglose.total_neto}}
    .modal(:class="{ 'is-active': modal }")
      .modal-background
      .modal-card
        header.modal-card-head
          p.modal-card-title
            b AGREGAR {{titulo_modal}}
          button.delete(@click='modal=false')
        section.modal-card-body
          form
            .columns
              .column
                label.label Clave
                p.select
                  select(v-model='concepto', @change='cambiaConcepto()')
                    option(v-for='c in conceptos', :value='c') {{c.clave}}
              .column(v-if='concepto')
                label.label Descripción
                p.control
                  input.input(v-model='nuevo.descripcion' :disabled="!nuevo.editable" type='text')
              .column(v-if='concepto')
                label.label Monto
                p.control
                  input.input(v-model='nuevo.valor' :disabled="!nuevo.editable" type='text')
        footer.modal-card-foot
          a.button.is-success(role='button', @click='guardarConcepto()', :disabled='!guardar')
            span.icon
              i.fa.fa-check
            span Agregar concepto
          a.button(role='button', @click='modal=false') Cancelar
</template>

<script>
import PanelConceptos from './PanelConceptos'
import { mapGetters, mapState, mapActions } from 'vuex'
export default {
  name: 'DesgloseEmpleado',
  components: {
    'panel-conceptos': PanelConceptos
  },
  data () {
    return {
      desglose: {},
      modal: false,
      guardar: false,
      titulo_modal: '',
      conceptos: [],
      concepto: {},
      nuevo: {},
      idNomina: 0,
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
    subtotal: function () {
      return (this.desglose.total_percepciones - this.desglose.total_deducciones).toFixed(2)
    },
    ...mapGetters({
      getNominaById: 'nominas/getNominaById'
    }),
    ...mapState(['catalogos'])
  },
  watch: {
    modal: function (val) {
      if (!val) {
        this.concepto = {}
        this.nuevo = {}
      }
    },
    'empleado.conceptos': function (val) {
      console.log('cambia conceptos')
      this.$set(this.desglose, 'total_isr', this.desglose.total_isr)
    },
    'nuevo.valor': function (val) {
      this.guardar = false
      if (val > 0) {
        this.guardar = true
      }
    }
  },
  methods: {
    ...mapActions({
      getDesglose: 'desglosenominas/getDesglose'
    }),
    cambiaConcepto: function () {
      console.log(this.concepto)
      if (this.concepto) {
        this.nuevo = {
          empleado: this.id_empleado,
          clave: this.concepto.clave,
          tipo_concepto: this.tipo,
          descripcion: this.concepto.descripcion,
          valor: this.concepto.valor,
          editable: this.concepto.editable

        }
      }
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
      if (arg === 'PERCEPCION') {
        this.titulo_modal = 'PERCEPCIÓN'
        this.conceptos = this.catalogos.percepciones
      } else {
        this.titulo_modal = 'DEDUCCIÓN'
        this.conceptos = this.catalogos.deducciones
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
    this.idEmpleado = this.$route.params.empleado
    this.idNomina = this.$route.params.id
    this.nomina = this.getNominaById(this.idNomina)
    this.getDesglose([this.idNomina, this.idEmpleado]).then(
      (response) => {
        this.desglose = response
      }
    )
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
