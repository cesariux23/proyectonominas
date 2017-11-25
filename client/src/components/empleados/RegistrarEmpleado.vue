<template>
  <div class="RegistrarEmpleado">
    <router-link :to="{ path: '/empleados'}" class="button is-info is-outlined" title="Volver al listado de empleados">
      <span class="icon"><i class="fa fa-arrow-left"></i></span>
    </router-link>
    <h1 class="title is-inline">
      Alta de empleado
    </h1>

    <div class="box">
        <form @submit.prevent ="guardar">
          <formulario-empleado :empleado='empleado' full></formulario-empleado>
          <hr>
          <button type="submit" name="button" class="button is-primary">
            <span class="icon">
              <i class="fa fa-check"></i>
            </span>
            <span>
              Registrar empleado
            </span>
          </button>
        </form>
        {{empleado}}
    </div>
  </div>
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
      url: ''
    }
  },
  methods: {
    guardar () {
      const self = this
      this.saveEmpleado(this.empleado).then((response) => {
        self.addEmpleado(response.data)
        self.$toast.open({
          duration: 10000,
          message: `Se ha registrado correctamente.`,
          position: 'is-top-right',
          type: 'is-success'
        })

        Router.push('/empleados/' + response.data.id)
      }, (err) => {
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
