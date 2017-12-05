<template lang="pug">
  .movimientos
    .columns
        .column
          router-link.button.is-info.is-outlined(:to="{ path: '/empleados/'+id}" title="Detalle del empleado")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline  {{title}}
    form(@submit.prevent="guardar")
      HeaderEmpleado(:empleado="empleado" :baja="!historico")
      DatosPuestoForm(:puesto_actual="puesto" :tipo_contrato="tipo_contrato" :title="title_puesto" :fin="historico")
      p.control
        button.button.is-primary(type="submit")
          b-icon(icon="check")
          span Guardar
</template>
<script>
  import DatosPuestoForm from './partials/DatosPuestoForm'
  import HeaderEmpleado from './partials/HeaderEmpleado'
  import moment from 'moment'
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
        puesto: {
          funcion: 'AUXILIAR'
        },
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
      this.updateEmpleadoData()
    },
    methods: {
      updateEmpleadoData () {
        this.empleado = this.getEmpleadoById(this.id) || this.empleado
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
      guardar () {
        // Se validan las fechas de inicio y fin
        if (this.empleado.puesto_actual.fecha_fin >= this.puesto.fecha_inicio) {
          this.$toast.open({
            duration: 5000,
            message: 'La fecha de inicio debe de ser posterior a <br> la fecha finalización del puesto actual.',
            position: 'is-top-right',
            type: 'is-danger'
          })
        }
      },
      ...mapActions([
        'getEmpleado',
        'updateEmpleado'
      ])
    },
    computed: {
      ...mapGetters([
        'getEmpleadoById'
      ])
    },
    watch: {
      'empleado': {
        handler (value) {
          if (value.puesto_actual.plaza && !this.historico) {
            this.$set(this.puesto, 'plaza', value.puesto_actual.plaza)
          }
        },
        deep: true
      },
      'empleado.puesto_actual.fecha_fin': {
        handler (value) {
          if (value) {
            const date = moment(value).add(1, 'd')
            console.log(date)
            this.$set(this.puesto, 'fecha_inicio', date.format('YYYY-MM-DD'))
          }
        }
      }
    }
  }
</script>

