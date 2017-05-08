<template>
  <div class="FormularioEmpleado">
    <div class="columns">
      <div class="column is-2">
        <label class="label">RFC</label>
        <p class="control">
          <input class="input" type="text" placeholder="RFC a minimo 10 caracteres" v-model="personal.rfc" required @change="cambiaRfc">
        </p>
      </div>
      <div class="column is-2">
        <label class="label">CURP</label>
        <p class="control">
          <input class="input" type="text" placeholder="CURP" v-model="personal.curp" @change="cambiaCurp">
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Fecha de nacimiento</label>
        <p class="control">
          <datepicker v-model="personal.fecha_nacimiento" language="es" required input-class="input" wrapper-class="date-picker" format="dd/MMM/yyyy" clear-button></datepicker>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Sexo</label>
        <p class="select">
          <select v-model="personal.sexo" required>
            <option value="MUJER">MUJER</option>
            <option value="HOMBRE">HOMBRE</option>
          </select>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Numero de seguridad social</label>
        <p class="control">
          <input class="input" type="text" placeholder="ISSSTE" v-model="personal.nss">
        </p>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label class="label">Nombre</label>
        <p class="control">
          <input class="input" type="text" placeholder="Nombre" v-model="personal.nombre" required>
        </p>
      </div>
      <div class="column">
        <label class="label">Primer apellido</label>
        <p class="control">
          <input class="input" type="text" placeholder="Primer Apellido" v-model="personal.primer_apellido" required>
        </p>
      </div>
      <div class="column">
        <label class="label">Segundo apellido</label>
        <p class="control">
          <input class="input" type="text" placeholder="Segundo apellido" v-model="personal.segundo_apellido">
        </p>
      </div>
    </div>
    <div class="columns">
      <div class="column is-4">
        <label class="label">Correo electronico</label>
        <p class="control">
          <input class="input" type="text" placeholder="Text input" v-model="personal.correo_electronico">
        </p>
      </div>
      <div class="column">
        <label class="label">Forma de pago</label>
        <p class="select">
          <select v-model="personal.tipo_pago" required>
            <option value="CHEQUE">CHEQUE</option>
            <option value="DEPOSITO">DEPOSITO BANCARIO</option>
          </select>
        </p>
      </div>
      <div class="column is-2">
        <label class="label">Banco</label>
        <p class="select">
          <select v-model="personal.banco">
            <option value="BANCOMER">BANCOMER</option>
            <option value="BANAMEX">BANAMEX</option>
            <option value="HSBC">HSBC</option>
          </select>
        </p>
      </div>
      <div class="column">
        <label class="label">Número de cuenta bancaria</label>
        <p class="control">
          <input class="input" type="text" placeholder="Número de cuenta bancaria" v-model="personal.numero_cuenta">
        </p>
      </div>
    </div>
    <h4 class="title is-4">DATOS LABORALES</h4>
    <hr>
    <div class="columns">
      <div class="column">
        <label class="label">tipo de contrato</label>
        <p class="select">
          <select v-model="personal.tipo_contrato" required>
            <option value="BASE">BASE</option>
            <option value="CONFIANZA">CONFIANZA</option>
            <option value="HONORARIOS">HONORARIOS</option>
          </select>
        </p>
      </div>
      <div class="column">
        <label class="label">Número de Empleado</label>
        <p class="control">
          <input class="input" type="text" placeholder="numero de empleado" v-model="personal.numero_empleado" required>
        </p>
      </div>
      <div class="column">
        <label class="label">Clave de la plaza</label>
      </div>
      <div class="column">
        <label >coordinador de unidad y servicios especializados</label>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label class="label">Puesto</label>
        <p class="control">
          <input type="text" class="input" placeholder="Nombre del puesto o funcion que desempleña en el Instituto" v-model="empleado.puesto">
        </p>
      </div>
      <div class="column is-4">
        <label class="label">Adscripción</label>
        <p class="select">
          <select v-model="empleado.adscripcion">
            <option v-for="a in adscripciones" :value="a.id">{{a.adscripcion}}</option>
          </select>
        </p>
      </div>
      <div class="column">
        <label class="label">Fecha de inicio</label>
        <p class="control">
          <datepicker v-model="empleado.fecha_inicio" language="es" required input-class="input" wrapper-class="date-picker" format="dd/MMM/yyyy" clear-button></datepicker>
        </p>
      </div>
      <div class="column">
        <label class="label">Fecha de finalización</label>
        <p class="control">
          <datepicker v-model="empleado.fecha_fin" language="es" required input-class="input" wrapper-class="date-picker" format="dd/MMM/yyyy" clear-button></datepicker>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import Datepicker from 'vuejs-datepicker'
export default {
  name: 'FormularioEmpleado',
  components: {
    Datepicker
  },
  data () {
    return {
      adscripciones: []
    }
  },
  props: ['personal', 'empleado'],
  methods: {
    getAdscripciones: function () {
      var self = this
      this.$io.socket.get('/adscripcion', function (data) {
        self.adscripciones = data
      })
    },
    cambiaCurp: function () {
      let sexo = ''
      if (this.personal.curp.length === 18) {
        sexo = this.personal.curp.substr(10, 1)
        this.$set(this.personal, 'sexo', sexo.toLowerCase() === 'h' ? 'HOMBRE' : 'MUJER')
      }
    },
    cambiaRfc: function () {
      if (this.personal.rfc.length >= 10) {
        let fechaNacimiento = this.personal.rfc.substr(4, 6)
        let fecha = new Date(fechaNacimiento.substr(0, 2), fechaNacimiento.substr(2, 2) - 1, fechaNacimiento.substr(4, 2))
        this.$set(this.personal, 'fecha_nacimiento', fecha)

        console.log(fecha)
        // this.$set(this.personal, 'sexo', sexo.toLowerCase() === 'h' ? 'HOMBRE' : 'MUJER')
      }
    }
  },
  mounted: function () {
    this.getAdscripciones()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.date-picker{
  display: flex;
}
</style>
