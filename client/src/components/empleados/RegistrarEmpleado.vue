<template lang="pug">
  .RegistrarEmpleado
    b-loading(:active.sync="isLoading")
    router-link.button.is-info.is-outlined(:to="{ path: '/empleados'}" title="Volver al listado de empleados")
      span.icon
          i.fa.fa-arrow-left
    h1.title.is-inline Alta de empleado
    .box
      form.form(@submit.prevent ="guardar")
        formulario-empleado(:empleado='empleado')
        hr
        button.button.is-primary(type="submit")
          span.icon
            i.fa.fa-check
          span Registrar empleado
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
import Router from '../../router'

import { Quincena } from '../../utils/Quincena'
import { mapActions, mapMutations } from 'vuex'

export default {
  name: 'RegistrarEmpleado',
  components: {
    FormularioEmpleado,
    Quincena
  },
  data () {
    return {
      empleado: {
        datos_personales: {
          tipo_pago: 'DEPOSITO'
        },
        puesto_actual: {
          fecha_inicio: Quincena.quincenaActual().inicio.toDate(),
          funcion: 'AUXILIAR'
        },
        tipo_contrato: 'HONORARIOS',
        fecha_alta: Quincena.quincenaActual().inicio.toDate()
      },
      url: '',
      isLoading: false
    }
  },
  methods: {
    guardar () {
      const self = this
      this.isLoading = true
      if (
        this.empleado.tipo_contrato !== 'HONORARIOS' &&
        !this.empleado.puesto_actual.plaza_id
        ) {
        self.$toast.open({
          duration: 5000,
          message: `No se ha especificado una clave de plaza valida.`,
          position: 'is-top-right',
          type: 'is-danger'
        })
        this.isLoading = false
        return true
      }
      this.saveEmpleado(this.empleado).then((response) => {
        self.isLoading = false
        self.addEmpleado(response.data)
        self.$toast.open({
          duration: 10000,
          message: `Se ha registrado correctamente.`,
          position: 'is-top-right',
          type: 'is-success'
        })

        Router.push('/empleados/' + response.data.id)
      }, (err) => {
        self.isLoading = false
        self.$toast.open({
          duration: 10000,
          message: err,
          position: 'is-top-right',
          type: 'is-danger'
        })
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
