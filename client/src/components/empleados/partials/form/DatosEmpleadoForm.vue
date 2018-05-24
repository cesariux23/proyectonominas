<template lang="pug">
  .box
    h4.title.is-4 Datos laborales
    hr
    .columns
      .column
        b-field(label="Tipo Contrato")
          b-select(
            v-model="empleado.tipo_contrato"
            placeholder="Tipo de contrato"
            expanded
            required
            v-if="!empleado.id"
            )
            option(v-for="tc in catalogos.tipo_contrato" :value="tc") {{tc}}
          span(v-else) {{empleado.tipo_contrato}}

      .column.is-3.in(v-if="empleado.tipo_contrato=='BASE'")
        b-field(label="tipo de nombramiento")
          b-select(
            v-model="empleado.tipo_nombramiento"
            placeholder="Nombramiento"
            expanded
            required
            )
            option(v-for="tc in catalogos.tipo_nombramiento" :value="tc") {{tc}}
      .column
        label.label Número de Empleado*
        p.control
          input.input(type="text" placeholder="Último disponible" v-model="empleado.numero_empleado" required)
      .column
        b-field(label="Fecha de alta*")
          input.input(
            type="date"
            v-model="empleado.fecha_alta"
           required)
      .column(v-if="empleado.status =='BAJA'")
        b-field(label="Fecha de baja*")
          input.input(
            type="date"
            v-model="empleado.fecha_baja"
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
