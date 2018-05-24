<template lang="pug">
  .DetalleEmpleado
    b-loading(:active.sync="isLoading")
    div(v-if="empleado")
      .columns
        .column
          router-link.button.is-info.is-outlined(:to="{name: 'listaEmpleados'}" title="Volver al listado de empleados")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline
            |  Datos del empleado
        .column
          b-field(grouped position="is-right")
            p.control
              b-dropdown(
                v-model="status"
                position="is-bottom-left")
                button.button(slot="trigger" :class="statusClass")
                  span
                    b Status:
                    u {{empleado.status }}
                  b-icon(icon="chevron-down")
                b-dropdown-item(value="ACTIVO" v-if="empleado.status === 'LICENCIA'")
                  b-icon(icon="plus-circle")
                  | REACTIVAR EMPLEADO
                // -
                  b-dropdown-item(value="ACTIVO" v-if="empleado.status === 'ACTIVO'")
                    b-icon(icon="star")
                    | COMISIONADO
                //
                b-dropdown-item(value="LICENCIA")
                  b-icon(icon="pause-circle")
                  | LICENCIA
                b-dropdown-item(value="BAJA")
                  b-icon(icon="minus-circle")
                  | BAJA DEFINITIVA
            p.control
              router-link.button.is-primary.is-outlined(:to="{ name: 'movimientos', params:{id: empleado.id, accion: 'nuevo'}}")
                b-icon(icon="send")
                span Registrar movimiento
            p.control
              button.button.is-light(type="button")
                b-icon(icon="print")
                span Imprimir
      .box
        Details(:data='empleado.datos_personales' :id='empleado.id', :details ="maps.datos_personales")
      .box
        Details(:data='empleado' :id='empleado.id', :details ="maps.datos_laborales")
      .box
        Details(:data='empleado.puesto_actual' :id='empleado.id', :details ="maps.puesto_actual")
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Historial laboral

            .column.is-right
              router-link.button(:to="{ name: 'movimientos', params:{id: empleado.id, accion: 'historico'}}")
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

    b-modal(:active.sync="showModalStatus"
    has-modal-card)
      form(@submit.prevent="cambiarStatus")
        .modal-card
          .modal-card-head
            .modal-card-title Cambiar de estatus
            button.delete(type="button" aria-label="close" @click="showModalStatus = false")
          .modal-card-body
            .content
              b-field(label="Nuevo estatus para el empleado" v-if="catalogos.status")
                b-select(
                  placeholder="Seleccione un estatus"
                  v-model="nuevo_status.substatus"
                  expanded
                  required)
                  option(v-for="s in catalogos.status[status]" :value="s") {{s}}
              .columns
                .column(v-if="showInicio")
                  b-field(label="Fecha inicio")
                    input.input(
                      type="date"
                      v-model='nuevo_status.fecha_inicio'
                      required)
                .column(v-if="showFin")
                  b-field(label="Fecha fin")
                    input.input(
                      type="date"
                      v-model='nuevo_status.fecha_fin'
                      required)
                .column(v-if="showBaja")
                  b-field(label="Fecha baja")
                    input.input(
                      type="date"
                      v-model='nuevo_status.fecha_baja'
                      required)
          .modal-card-foot
              button.button.is-danger(type="button" @click="showModalStatus = false")
                b-icon(icon="times")
                span Cancelar
              button.button.is-primary(type="submit")
                b-icon(icon="check")
                span Cambiar status
</template>
<script>
import ColumnDato from '../utils/ColumnDato'
import Details from './partials/EmpleadoDetails'
import { mapGetters, mapActions, mapState } from 'vuex'

export default {
  name: 'DetalleEmpleado',
  components: {
    ColumnDato,
    Details
  },
  data () {
    return {
      id: null,
      status: '',
      showModalStatus: false,
      isLoading: false,
      showInicio: false,
      showFin: false,
      showBaja: false,
      nuevo_status: {
        status_general: ''
      },
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
              {header: 'Tipo Nombramiento', field: 'tipo_nombramiento'},
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
              {header: 'Clave de la Plaza', field: 'plaza.clave'},
              {header: 'Plaza', field: 'plaza.nombre'},
              {header: 'Función', field: 'funcion'},
              {header: 'Adscripción', field: 'adscripcion.nombre'},
              {header: 'Fecha de Inicio', field: 'fecha_inicio'}
            ]
          ]
        }
      },
      // empleado
      empleado: {
        id: 0,
        datos_personales: {},
        puesto_actual: {}
      }
    }
  },
  methods: {
    updateEmpleadoData () {
      this.empleado = this.getEmpleadoById(this.id)
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
    cambiarStatus () {
      this.$dialog.confirm({
        title: 'Confirmar Acción',
        message: `Empleado: </br>
                  <b>${this.empleado.datos_personales.nombre_completo}</b>
                  </br>
                  Cambio de estatus:
                  </br>
                  <b>${this.empleado.status}</b>
                  <i class="fa fa-arrow-right"></i>
                  <b> ${this.nuevo_status.status}</b>`,
        confirmText: 'Cambiar',
        cancelText: 'Cancelar',
        type: 'is-info',
        hasIcon: true,
        onConfirm: () => {
          this.showModalStatus = false
          // Se guarda el nuevo status en la base de datos
          this.updateEmpleado({id: this.id, data: this.nuevo_status}).then((response) => {
            this.updateEmpleadoData()
            this.$toast.open({
              duration: 5000,
              message: `Se cambio el status correctamente.`,
              position: 'is-top-right',
              type: 'is-success'
            })
          })
        }
      })
    },
    ...mapActions({
      getEmpleado: 'empleados/getEmpleado',
      updateEmpleado: 'empleados/updateEmpleado'
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
