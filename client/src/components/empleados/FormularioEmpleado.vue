<template>
  <div class="FormularioEmpleado">
    <div class="columns">
      <div class="column is-2">
        <label class="label">RFC</label>
        <p class="control">
          <input class="input" type="text" placeholder="RFC a minimo 10 caracteres" v-model="empleado.rfc" required>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">CURP</label>
        <p class="control">
          <input class="input" type="text" placeholder="CURP" v-model="empleado.curp">
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Fecha de nacimiento</label>
        <p class="control">
          <input class="input" type="text" placeholder="DD/MM/AAAA" v-model="empleado.fecha_nacimiento" required>
          <datepicker placeholder="DD/MM/AAAA" v-model="empleado.fecha_nacimiento" :config="{ dateFormat: 'd/m/Y', locale: 'es'}" required="true"></datepicker>

        </p>
      </div>
      <div class="column is-1">
        <label class="label">Sexo</label>
        <p class="select">
          <select v-model="empleado.sexo" required>
            <option value="MUJER">MUJER</option>
            <option value="HOMBRE">HOMBRE</option>
          </select>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Numero de seguridad social</label>
        <p class="control">
          <input class="input" type="text" placeholder="ISSSTE" v-model="empleado.nss">
        </p>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label class="label">Nombre</label>
        <p class="control">
          <input class="input" type="text" placeholder="Nombre" v-model="empleado.nombre" required>
        </p>
      </div>
      <div class="column">
        <label class="label">Primer apellido</label>
        <p class="control">
          <input class="input" type="text" placeholder="Primer Apellido" v-model="empleado.primer_apellido" required>
        </p>
      </div>
      <div class="column">
        <label class="label">Segundo apellido</label>
        <p class="control">
          <input class="input" type="text" placeholder="Segundo apellido" v-model="empleado.segundo_apellido">
        </p>
      </div>
    </div>
    <div class="columns">
      <div class="column is-4">
        <label class="label">Correo electronico</label>
        <p class="control">
          <input class="input" type="text" placeholder="Text input" v-model="empleado.correo_electronico">
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Forma de pago</label>
        <p class="select">
          <select v-model="empleado.tipo_pago" required>
            <option value="CHEQUE">CHEQUE</option>
            <option value="DEPOSITO">DEPOSITO BANCARIO</option>
          </select>
        </p>
      </div>
      <div class="column is-1">
        <label class="label">Banco</label>
        <p class="select">
          <select v-model="empleado.banco">
            <option value="BANCOMER">BANCOMER</option>
            <option value="BANAMEX">BANAMEX</option>
            <option value="HSBC">HSBC</option>
          </select>
        </p>
      </div>
      <div class="column">
        <label class="label">Número de cuenta bancaria</label>
        <p class="control">
          <input class="input" type="text" placeholder="Número de cuenta bancaria" v-model="empleado.numero_cuenta">
        </p>
      </div>
    </div>
    <h4 class="title is-4">DATOS LABORALES</h4>
    <hr>
    <div class="columns">
      <div class="column is-1">
        <label class="label">tipo de contrato</label>
        <p class="select">
          <select v-model="empleado.tipo_contrato" required>
            <option value="BASE">BASE</option>
            <option value="CONFIANZA">CONFIANZA</option>
            <option value="HONORARIOS">HONORARIOS</option>
          </select>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Número de Empleado</label>
        <p class="control">
          <input class="input" type="text" placeholder="numero de empleado" v-model="empleado.numero_empleado" required>
        </p>
      </div>
      <div class="column is-4">
        <label class="label">Adscripción</label>
        <p class="select">
          <select v-model="empleado.adscripcion">
            <option value="NNNNN">SUBDIRECCION DE ACREDITACIÓN Y SISTEMAS DE CONTROL EDUCATIVO</option>
          </select>
        </p>
      </div>
      <div class="column">
        <label class="label">Puesto</label>
        <p class="control">
          <input type="text" class="input" placeholder="Nombre del puesto o funcion que desempleña en el Instituto">
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from 'vue-bulma-datepicker'
export default {
  name: 'FormularioEmpleado',
  components: {
    Datepicker
  },
  props: ['empleado']
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
