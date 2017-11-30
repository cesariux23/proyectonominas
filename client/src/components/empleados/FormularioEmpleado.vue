<template lang="pug">
  div
    DatosPersonalesForm(:datos_personales="empleado.datos_personales" v-if="editable.datos_personales")
    br
    DatosEmpleadoForm(:empleado="empleado" v-if="editable.empleado")
    br
    DatosPuestoForm(:puesto_actual="empleado.puesto_actual" :tipo_contrato="empleado.tipo_contrato" v-if="editable.puesto_actual")

</template>
<script>
import Datepicker from 'vuejs-datepicker'
import DatosPersonalesForm from './partials/DatosPersonalesForm'
import DatosEmpleadoForm from './partials/DatosEmpleadoForm'
import DatosPuestoForm from './partials/DatosPuestoForm'

export default {
  name: 'FormularioEmpleado',
  components: {
    Datepicker,
    DatosPersonalesForm,
    DatosEmpleadoForm,
    DatosPuestoForm
  },
  data () {
    return {
    }
  },
  props: ['empleado', 'editable'],
  watch: {
    'empleado': function (value) {
      // this.datos_personales = value.datos_personales
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
