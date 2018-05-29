<template lang="pug">
  .movimientos
    .columns
        .column
          router-link.button.is-info.is-outlined( :to="{ name: 'detalleEmpleado', params: {id: empleado.id}}" title="Detalle del empleado")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline  {{title}}
    form(@submit.prevent="guardar")
      HeaderEmpleado(:empleado="empleado" :baja="!historico")
      DatosPuestoForm(:puesto_actual="puesto" :tipo_contrato="empleado.tipo_contrato" :title="title_puesto" :fin="historico")
      p.control
        button.button.is-primary(type="submit")
          b-icon(icon="check")
          span Guardar
</template>
<script>
  import DatosPuestoForm from './partials/form/DatosPuestoForm'
  import HeaderEmpleado from './partials/HeaderEmpleado'
  import moment from 'moment'
  import { Quincena } from '@/utils/Quincena'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    name: 'Movimientos',
    components: {
      DatosPuestoForm,
      HeaderEmpleado
    },
    data () {
      return {
        title: 'Histórico de movimientos',
        title_puesto: 'Movimiento histórico',
        id: 0,
        puesto: {},
        tipo_contrato: 'BASE',
        empleado: {},
        baja: false,
        historico: true
      }
    },
    mounted () {
      this.id = this.$route.params.id
      this.historico = this.$route.params.accion !== 'nuevo'
      this.title = this.historico ? this.title : 'Registro de nuevo movimiento'
      this.title_puesto = this.historico ? this.title_puesto : 'Nuevo puesto'
      this.puesto.empleado_id = this.id
      this.updateEmpleadoData()
    },
    methods: {
      updateEmpleadoData () {
        this.empleado = this.getEmpleadoById(this.id)
        this.isLoading = true
        this.getEmpleado([this.id]).then((result) => {
          this.isLoading = false
          // inicializa el valor del puesto con los valores existentes
          delete result.puesto_actual.id
          this.$set(this, 'puesto', Object.assign({}, result.puesto_actual))
          result.puesto_actual.fecha_fin = (moment(Quincena.quincenaActual().inicio).subtract(1, 'd')).format('YYYY-MM-DD')
          this.empleado = result
        }, (error) => {
          this.isLoading = false
          this.$router.push('/empleados')
          this.$toast.open({
            duration: 5000,
            message: error.error,
            position: 'is-top-right',
            type: 'is-danger'
          })
        })
      },
      guardar () {
        // Se validan las fechas de inicio y fin
        let error
        if (this.puesto.fecha_inicio < moment(this.empleado.fecha_alta).format('YYYY-MM-DD')) {
          error = 'La fecha de inicio debe de ser posterior a <br> la fecha de ingreso.'
        }
        if (this.puesto.fecha_fin >= this.empleado.puesto_actual.fecha_inicio) {
          error = 'La fecha de finalización debe de ser anterior a <br> la fecha de incio del puesto actual.'
        }
        if (error) {
          this.$toast.open({
            duration: 5000,
            message: error,
            position: 'is-top-right',
            type: 'is-danger'
          })
          return false
        }

        // se almacena el cambio en la base de datos
        this.$dialog.confirm({
          title: 'Confirmar acción',
          message: `¿Deseas registrar el movimiento para el empleado <b>${this.empleado.datos_personales.nombre_completo}</b>?
                    <br>` + (this.puesto.plaza ? `<b v-if("puesto.plaza")>Puesto:</b> ${this.puesto.plaza.nombre} <br>` : '') +
                    `<b>Función</b>: ${this.puesto.funcion}`,
          confirmText: 'Registrar',
          cancelText: 'Cancelar',
          type: 'is-info',
          hasIcon: true,
          onConfirm: () => {
            let puesto = {}
            Object.assign(puesto, this.puesto)
            delete puesto.adscripcion
            delete puesto.plaza
            puesto.fecha_fin = puesto.fecha_fin || null
            const data = {
              id: this.id,
              puesto: puesto
            }
            if (!this.historico) {
              data.fecha_fin = this.empleado.puesto_actual.fecha_fin
            }
            this.saveMovimiento(data).then((result) => {
              this.$toast.open({
                duration: 5000,
                message: 'movimiento registrado correctamente.',
                position: 'is-top-right',
                type: 'is-success'
              })
              this.$router.push('/empleado/' + this.id)
            }, (error) => {
              this.$toast.open({
                duration: 5000,
                message: error.data.error,
                position: 'is-top-right',
                type: 'is-danger'
              })
            })
          }
        })
      },
      ...mapActions({
        getEmpleado: 'empleados/getEmpleado',
        updateEmpleado: 'empleados/updateEmpleado',
        saveMovimiento: 'saveMovimiento'
      })
    },
    computed: {
      fechaFin () {
        return this.empleado.puesto_actual ? this.empleado.puesto_actual.fecha_fin : null
      },
      ...mapGetters({
        getEmpleadoById: 'empleados/getEmpleadoById'
      })
    },
    watch: {
      'empleado.puesto_actual.fecha_fin': {
        handler (value) {
          if (value && !this.historico) {
            const date = moment(value).add(1, 'd')
            this.$set(this.puesto, 'fecha_inicio', date.format('YYYY-MM-DD'))
          }
        }
      }
    }
  }
</script>
