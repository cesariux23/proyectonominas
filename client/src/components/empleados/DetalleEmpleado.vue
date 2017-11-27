<template lang="pug">
  .DetalleEmpleado
    b-loading(:active.sync="isLoading")
    div(v-if="empleado")
      .columns
        .column
          router-link.button.is-info.is-outlined(:to="{ path: '/empleados'}" title="Volver al listado de empleados")
            span.icon
              i.fa.fa-arrow-left
          h1.title.is-inline
            | Datos del empleado
        .column.is-right
          button.button.is-primary(type="button")
            span.icon
              i.fa.fa-print
            span Imprimir
      .box
        header.is-underlined
          .columns
            .column
              h1.title {{empleado.datos_personales.nombre_completo}}
              h4.subtitle {{empleado.datos_personales.rfc}}
            
            .column.is-right
              router-link.button.is-danger.is-outlined(:to="{ name: 'empleadoEdit', params:{id: empleado.id}}")
                span.icon
                  i.fa.fa-minus-circle
                span Realizar baja
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id}}" title="Editar datos laborales")
                span.icon
                  i.fa.fa-refresh
                span Modificar
              
        .columns
          column-dato(encabezado="Núm. de empleado") {{empleado.numero_empleado}}
          column-dato(encabezado="Tipo de contrato") {{empleado.tipo_contrato}}
          column-dato(encabezado="Clave de la plaza" v-if="empleado.puesto_actual.plaza")
              | {{empleado.puesto_actual.plaza.clave}} -- {{empleado.puesto_actual.plaza.nombre}}
          column-dato(encabezado="Función") {{empleado.puesto_actual.funcion}}
          column-dato(encabezado="Adscripción" v-if="empleado.puesto_actual.adscripcion") {{empleado.puesto_actual.adscripcion.nombre}}
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Datos personales
            .column.is-right
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id}}")
                span.icon
                    i.fa.fa-pencil
                span Editar
              
        .content
          .columns
            column-dato(encabezado="RFC") {{empleado.datos_personales.rfc}}
            column-dato(encabezado="Nombre(s)") {{empleado.datos_personales.nombre}}
            column-dato(encabezado="Primer apellido") {{empleado.datos_personales.primer_apellido}}
            column-dato(encabezado="segundo apellido") {{empleado.datos_personales.segundo_apellido}}
          
          .columns
            column-dato(encabezado="CURP") {{empleado.datos_personales.curp}}
            column-dato(encabezado="Fecha de nacimiento") {{empleado.datos_personales.fecha_nacimiento}}
            column-dato(encabezado="Edad") {{empleado.datos_personales.edad}}
            column-dato(encabezado="Sexo") {{empleado.datos_personales.sexo}}
            column-dato(encabezado="NSS") {{empleado.datos_personales.nss}}
          
          .columns
            column-dato(encabezado="Correo electrónico") {{empleado.datos_personales.correo}}
            column-dato(encabezado="Forma de pago") {{empleado.datos_personales.tipo_pago}}
            column-dato(encabezado="Banco") {{empleado.datos_personales.banco}}
            column-dato(encabezado="Número de cuenta bancaria") {{empleado.datos_personales.numero_cuenta}}
      .box
        header.is-underlined
          .columns
            .column
              h4.title.is-4 Historial laboral

            .column.is-right
              router-link.button(:to="{ name: 'empleadoEdit', params:{id: empleado.id}}")
                span.icon
                  i.fa.fa-plus
                span Agregar
        div {{ empleado.historial }}
            
</template>

<script>
import ColumnDato from '../utils/ColumnDato'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DetalleEmpleado',
  components: {
    ColumnDato
  },
  data () {
    return {
      empleado: {
        datos_personales: {},
        puesto_actual: {}
      },
      isLoading: false
    }
  },
  methods: {
    updateEmpleado () {
      let id = this.$route.params.id
      this.empleado = this.getEmpleadoById(id)
      let self = this
      this.isLoading = true
      this.getEmpleado(id).then((result) => {
        this.isLoading = false
        self.empleado = result
      })
    },
    ...mapActions([
      'getEmpleado'
    ])
  },
  computed: {
    // mix the getters into computed with object spread operator
    ...mapGetters([
      'getEmpleadoById'
    ])
  },
  mounted: function () {
    this.updateEmpleado()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
