<template lang="pug">
  .DetalleEmpleado
    b-loading(:active.sync="isLoading")
    div(v-if="empleado")
      .columns
        .column
          router-link.button.is-info.is-outlined(:to="{ path: '/empleados'}" title="Volver al listado de empleados")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline
            | Datos del empleado
        .column.is-right
          button.button.is-primary(type="button")
            span.icon
              i.fa.fa-print
            span Imprimir
      .box
        header.is-underlined
          .columns
            .column
              h1.title {{empleado.datos_personales.nombre_completo}} 
                b-dropdown(
                  v-model="status"
                  position="is-bottom-left")
                  button.button(slot="trigger" :class="statusClass")
                    span {{empleado.status }}
                    b-icon(icon="chevron-down")
                  b-dropdown-item(value="ACTIVO" v-if="empleado.status_general === 'LICENCIA'")
                    b-icon(icon="plus-circle")
                    | REACTIVAR EMPLEADO
                  // -
                    b-dropdown-item(value="ACTIVO" v-if="empleado.status_general === 'ACTIVO'")
                      b-icon(icon="star")
                      | COMISIONADO
                  //
                  b-dropdown-item(value="LICENCIA")
                    b-icon(icon="pause-circle")
                    | LICENCIA
                  b-dropdown-item(value="BAJA")
                    b-icon(icon="minus-circle")
                    | BAJA DEFINITIVA

              h4.subtitle {{empleado.datos_personales.rfc}}
            .column.is-3.is-right
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id, partial: 'puesto_actual'}}" title="Editar datos laborales")
                span.icon
                  i.fa.fa-refresh
                span Modificar puesto actual
              
        .columns
          column-dato(encabezado="Núm. de empleado") {{empleado.numero_empleado}}
          column-dato(encabezado="Tipo de contrato") {{empleado.tipo_contrato}}
          column-dato(encabezado="Puesto" v-if="empleado.puesto_actual.plaza")
            p {{empleado.puesto_actual.plaza.nombre}}
            p
              b {{empleado.puesto_actual.plaza.clave}}
          column-dato(encabezado="Función") {{empleado.puesto_actual.funcion}}
          column-dato(encabezado="Adscripción" v-if="empleado.puesto_actual.adscripcion") {{empleado.puesto_actual.adscripcion.nombre}}
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Datos personales
            .column.is-right
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id, partial: 'datos_personales'}}")
                span.icon
                    i.fa.fa-pencil
                span Editar
              
        .content
          .columns
            column-dato(encabezado="RFC") {{empleado.datos_personales.rfc}}
            column-dato(encabezado="Nombre(s)") {{empleado.datos_personales.nombre}}
            column-dato(encabezado="Primer apellido") {{empleado.datos_personales.primer_apellido}}
            column-dato(encabezado="segundo apellido") {{empleado.datos_personales.segundo_apellido}}
          
          .columns
            column-dato(encabezado="CURP") {{empleado.datos_personales.curp}}
            column-dato(encabezado="Fecha de nacimiento") {{empleado.datos_personales.fecha_nacimiento}}
            column-dato(encabezado="Edad") {{empleado.datos_personales.edad}}
            column-dato(encabezado="Sexo") {{empleado.datos_personales.sexo}}
            column-dato(encabezado="NSS") {{empleado.datos_personales.nss}}
          
          .columns
            column-dato(encabezado="Correo electrónico") {{empleado.datos_personales.correo}}
            column-dato(encabezado="Forma de pago") {{empleado.datos_personales.tipo_pago}}
            column-dato(encabezado="Banco") {{empleado.datos_personales.banco}}
            column-dato(encabezado="Número de cuenta bancaria") {{empleado.datos_personales.numero_cuenta}}
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Historial laboral

            .column.is-right
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id}}")
                span.icon
                  i.fa.fa-plus
                span Agregar
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
                  v-model="nuevo_status.status"
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
import { mapGetters, mapActions, mapState } from 'vuex'

export default {
  name: 'DetalleEmpleado',
  components: {
    ColumnDato
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
      // empleado
      empleado: {
        datos_personales: {},
        puesto_actual: {}
      }
    }
  },
  methods: {
    updateEmpleadoData () {
      this.empleado = this.getEmpleadoById(this.id)
      this.isLoading = true
      this.getEmpleado(this.id).then((result) => {
        this.isLoading = false
        this.empleado = result
      }, (error) => {
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
        title: 'Confirmar acción',
        message: '¿Deseas cambiar el status? <br> Empleado: </br> <b>' +
          this.empleado.datos_personales.nombre_completo +
          '</b> </br> Estatus:</br> <b>' +
          this.empleado.status +
          '</b>  <i class="fa fa-arrow-right"></i> <b> ' +
          this.nuevo_status.status +
          '</b>',
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
    ...mapActions([
      'getEmpleado',
      'updateEmpleado'
    ])
  },
  watch: {
    status: {
      handler (value) {
        this.$set(this.nuevo_status, 'status_general', value)
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
      switch (this.empleado.status_general) {
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
    ...mapGetters([
      'getEmpleadoById'
    ]),
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
