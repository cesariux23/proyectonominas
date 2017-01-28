<template>
  <div class="DesgloseEmpleado">
    <div class="box">
      -Empleado-
    </div>
    <div class="columns">
      <div class="column">
        <panel-conceptos titulo="PERCEPCIONES"></panel-conceptos>
      </div>
      <div class="column">
        <panel-conceptos titulo="DEDUCCIONES"></panel-conceptos>
      </div>
    </div>
  </div>
</template>

<script>
import PanelConceptos from './PanelConceptos'
export default {
  name: 'DesgloseEmpleado',
  components: {
    'panel-conceptos': PanelConceptos
  },
  data () {
    return {
      msg: 'Desgloce quincenal del empleado'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
