<template lang="pug">
  .RegistrarEmpleado
    b-loading(:active.sync="isLoading")
    router-link.button.is-info.is-outlined(:to="{ path: '/empleados'}" title="Volver al listado de empleados")
      span.icon
          i.fa.fa-arrow-left
    h1.title.is-inline  Alta de empleado
    form.form(@submit.prevent ="guardar")
      formulario-empleado(:empleado='empleado' :editable="editable")
      br
      button.button.is-primary(type="submit")
        span.icon
          i.fa.fa-check
        span Registrar empleado
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
import Router from '../../router'

import { Quincena } from '../../utils/Quincena'
import { mapActions, mapMutations, mapState } from 'vuex'

export default {
  name: 'RegistrarEmpleado',
  components: {
    FormularioEmpleado,
    Quincena
  },
  data () {
    return {
      editable: {
        datos_personales: true,
        empleado: true,
        puesto_actual: true
      },
      empleado: {
        status_general: 'ACTIVO',
        status: 'ACTIVO',
        datos_personales: {
          tipo_pago: 'DEPOSITO'
        },
        puesto_actual: {
          fecha_inicio: Quincena.quincenaActual().inicio.format('YYYY-MM-DD'),
          funcion: 'AUXILIAR'
        },
        tipo_contrato: 'HONORARIOS',
        fecha_alta: Quincena.quincenaActual().inicio.format('YYYY-MM-DD')
      },
      url: '',
      isLoading: false
    }
  },
  computed: {
    ...mapState(['catalogos'])
  },
  methods: {
    guardar () {
      if (
        this.empleado.tipo_contrato !== 'HONORARIOS' &&
        !this.empleado.puesto_actual.plaza_id
        ) {
        this.$toast.open({
          duration: 5000,
          message: `No se ha especificado una clave de plaza valida.`,
          position: 'is-top-right',
          type: 'is-danger'
        })
        return true
      }
      this.$dialog.confirm({
        title: 'Confirmar acción',
        message: `
        <p>¿Deseas dar de alta a <b> ${this.empleado.datos_personales.nombre + ' ' +
          this.empleado.datos_personales.primer_apellido || '' + ' ' +
          this.empleado.datos_personales.segundo_apellido || ''} </b> como personal de <b>${this.empleado.tipo_contrato}</b>?<p>
        <br>
        <p><b>IMPORTANTE</b>: Esta acción no se podrá deshacer.<p>
        `,
        confirmText: 'Confirmar alta',
        cancelText: 'Cancelar',
        type: 'is-info',
        hasIcon: true,
        onConfirm: () => {
          this.saveEmpleado(this.empleado).then((response) => {
            this.isLoading = false
            this.addEmpleado(response.data)
            this.$toast.open({
              duration: 10000,
              message: `Se ha registrado correctamente.`,
              position: 'is-top-right',
              type: 'is-success'
            })

            Router.push('/empleados/' + response.data.id)
          }, (err) => {
            this.isLoading = false
            this.$toast.open({
              duration: 10000,
              message: err,
              position: 'is-top-right',
              type: 'is-danger'
            })
          })
        }
      })
    },
    ...mapActions([
      'saveEmpleado',
      'fetchEmpleados'
    ]),
    ...mapMutations([
      'addEmpleado'
    ])
  },
  mounted: function () {
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
