<template>
  <div class="FormularioEmpleado">
    {{empleado}}
    <label class="label">Nombre</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.nombre" required>
    </p>
    <label class="label">Primer Apellido</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.primer_apellido" required>
    </p>
    <label class="label">segundo Apellido</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.segundo_apellido">
    </p>
    <label class="label">RFC</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.rfc" required>
    </p>
    <label class="label">CURP</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.curp">
    </p>
    <label class="label">Número de Empleado</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.num_empleado">
    </p>
    <label class="label">Correo electronico</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.correo_electronico">
    </p>
    <label class="label">tipo de contrato</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.tipo_contrato">
    </p>
    <label class="label">Sexo</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.sexo">
    </p>
    <label class="label">Forma de pago</label>
    <p class="control">
      <input class="input" type="text" placeholder="Text input" v-model="empleado.tipo_pago">
    </p>
  </div>
</template>

<script>
export default {
  name: 'FormularioEmpleado',
  props: ['empleado']
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
