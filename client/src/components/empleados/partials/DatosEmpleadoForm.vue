<template lang="pug">
  .Empleado
    h4.title.is-4 Datos laborales
    hr
    .columns
      .column
        b-field(label="Tipo de contrato")
          b-select(
            v-model="empleado.tipo_contrato"
            placeholder="Tipo de contrato"
            expanded
            required)
            option(v-for="tc in catalogos.tipo_contrato" :value="tc") {{tc}}

      .column.is-2.in(v-if="empleado.tipo_contrato=='BASE'")
        .field
          br
          b-checkbox(v-model="empleado.interinato") Esta cubriendo un interinato
      .column
        label.label Número de Empleado*
        p.control
          input.input(type="text" placeholder="numero de empleado" v-model="empleado.numero_empleado" required)
      .column
        b-field(label="Fecha de alta")
          input.input(
            type="date"
            v-model="empleado.fecha_alta"
           required)
</template>
<script>
  import { mapState } from 'vuex'

  export default {
    name: 'DatosEmpleadoForm',
    props: [
      'empleado'
    ],
    data () {
      return {
      }
    },
    computed: {
      ...mapState([
        'catalogos'
      ])
    }
  }
</script>
