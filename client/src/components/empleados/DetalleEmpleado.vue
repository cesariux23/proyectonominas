<template lang="pug">
  .DetalleEmpleado
    b-loading(:active.sync="isLoading")
    div(v-if="empleado")
      .columns
        .column
          router-link.button.is-info.is-outlined(:to="{name: 'indexEmpleados'}" title="Volver al listado de empleados")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline
            |  {{empleado ? empleado.datos_personales.nombre_completo : 'Datos del empleado'}}
        .column
          b-field(grouped position="is-right")
            p.control
              status-label(:status="empleado.status" :id="id" editable)
            p.control
              router-link.button.is-primary.is-outlined(:to="{ name: 'movimientos', params:{id: id, accion: 'nuevo'}}")
                b-icon(icon="send")
                span Registrar movimiento
            p.control
              button.button.is-light(type="button")
                b-icon(icon="print")
                span Imprimir
      .box
        Details(:data='empleado.datos_personales' :id='id', :details ="maps.datos_personales")
      .box
        Details(:data='empleado' :id='id', :details ="maps.datos_laborales")
      .box
        Details(:data='empleado.puesto_actual' :id='id', :details ="maps.puesto_actual")
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Historial laboral

            .column.is-right
              router-link.button(:to="{ name: 'movimientos', params:{id: id, accion: 'historico'}}")
                b-icon(icon="plus")
                span Agregar movimiento histórico
        b-table(
          :data= "empleado.historial"
          )
          template(slot-scope="props")
            b-table-column(label="ID" width="50" numeric)
              | {{ props.row.id }}
            b-table-column(label="Adscripción" string)
              | {{ props.row.adscripcion.nombre }}
            b-table-column(label="Puesto" string)
              span(v-if="props.row.plaza")
                b {{ props.row.plaza.clave }}
                |  -- {{ props.row.plaza.nombre }}
              span(v-else) --
            b-table-column(label="Función" string)
              | {{ props.row.funcion }}
            b-table-column(label="Desde" width="120" string)
              | {{ props.row.fecha_inicio }}
            b-table-column(label="Hasta" width="120" string)
              | {{ props.row.fecha_fin }}
</template>
<script>
import ColumnDato from '../utils/ColumnDato'
import StatusLabel from './partials/StatusLabel'
import Details from './partials/Details'
import { mapGetters, mapActions, mapState } from 'vuex'

export default {
  name: 'DetalleEmpleado',
  components: {
    ColumnDato,
    StatusLabel,
    Details
  },
  data () {
    return {
      id: null,
      status: '',
      showModalStatus: false,
      isLoading: false,
      // mapas para mostrar detalles
      maps: {
        datos_personales: {
          title: 'Datos Personales',
          partial: 'datos_personales',
          rows: [
            [
              {header: 'RFC', field: 'rfc'},
              {header: 'Nombre(s)', field: 'nombre'},
              {header: 'Primer Apellido', field: 'primer_apellido'},
              {header: 'Segundo Apellido', field: 'segundo_apellido'}
            ], [
              {header: 'CURP', field: 'curp'},
              {header: 'Fecha de Nacimiento', field: 'fecha_nacimiento'},
              {header: 'Edad', field: 'edad'},
              {header: 'Sexo', field: 'sexo'},
              {header: 'NSS', field: 'nss'}
            ], [
              {header: 'Forma de pago', field: 'tipo_pago'},
              {header: 'Banco', field: 'banco'},
              {header: 'Número de Cuenta', field: 'numero_cuenta'},
              {header: 'Cuenta CLABE', field: 'clabe'}
            ], [
              {header: 'Correo Electrónico', field: 'correo'}
            ]
          ]
        },
        datos_laborales: {
          title: 'Datos Laborales',
          partial: 'empleado',
          rows: [
            [
              {header: 'Núm. de Empleado', field: 'numero_empleado'},
              {header: 'Tipo de Contrato', field: 'tipo_contrato'},
              {header: 'Fecha de Alta', field: 'fecha_alta'},
              {header: 'Fecha de Baja', field: 'fecha_baja'}
            ]
          ]
        },
        puesto_actual: {
          title: 'Puesto Actual',
          partial: 'puesto_actual',
          rows: [
            [
              {header: 'Tipo Nombramiento', field: 'tipo_nombramiento'},
              {header: 'Clave de la Plaza', field: 'plaza.clave'},
              {header: 'Plaza', field: 'plaza.nombre'},
              {header: 'Función', field: 'funcion'},
              {header: 'Adscripción', field: 'adscripcion.nombre'},
              {header: 'Fecha de Inicio', field: 'fecha_inicio'}
            ]
          ]
        }
      }
    }
  },
  methods: {
    updateEmpleadoData () {
      this.isLoading = true
      this.getEmpleado([this.id]).then((result) => {
        this.isLoading = false
        this.empleado = result
      }, (error) => {
        console.log(error)
        this.isLoading = false
        this.$router.push('/empleados')
        this.$toast.open({
          duration: 5000,
          message: error.data.error,
          position: 'is-top-right',
          type: 'is-danger'
        })
      })
    },
    ...mapActions({
      getEmpleado: 'empleados/getEmpleado'
    })
  },
  watch: {
    status: {
      handler (value) {
        this.$set(this.nuevo_status, 'status', value)
        this.showInicio = this.showFin = this.showBaja = false
        switch (value) {
          case 'LICENCIA':
            this.showInicio = true
            this.showFin = true
            break
          case 'BAJA':
            this.showBaja = true
        }
        this.showModalStatus = true
      }}
  },
  computed: {
    empleado: {
      // resuelve el warning:
      // Computed property 'name' was assigned to but it has no setter
      get: function () {
        return this.getEmpleadoById(this.id)
      },
      set: function (val) {}
    },
    statusClass () {
      let _class = ''
      switch (this.empleado.status) {
        case 'ACTIVO':
          _class = 'is-success'
          break
        case 'LICENCIA':
          _class = 'is-info'
          break
        case 'BAJA':
          _class = 'is-danger'
          break
      }
      return _class
    },
    // mix the getters into computed with object spread operator
    ...mapGetters({
      getEmpleadoById: 'empleados/getEmpleadoById'
    }),
    ...mapState([
      'catalogos'
    ])
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.updateEmpleadoData()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
