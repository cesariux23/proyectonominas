<template lang="pug">
  div
    DatosPersonalesForm(:datos_personales="empleado.datos_personales" v-if="editable.datos_personales")
    DatosEmpleadoForm(:empleado="empleado" v-if="editable.empleado")
    DatosPuestoForm(:puesto_actual="empleado.puesto_actual" :tipo_contrato="empleado.tipo_contrato" v-if="editable.puesto_actual")

</template>
<script>
import Datepicker from 'vuejs-datepicker'
import DatosPersonalesForm from './partials/form/DatosPersonalesForm'
import DatosEmpleadoForm from './partials/form/DatosEmpleadoForm'
import DatosPuestoForm from './partials/form/DatosPuestoForm'

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
