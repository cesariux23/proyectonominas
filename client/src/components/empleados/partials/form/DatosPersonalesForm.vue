<template lang="pug">
  .box
    h4.title.is-4 Datos personales
    hr
    .columns
      .column
        b-field(label="RFC*")
          b-input(
            placeholder="RFC con Homoclave"
            v-model="datos_personales.rfc"
            minlength="13"
            maxlength="13"
            :loading = "isLoadingEmpleado"
            required)
      .column(v-if="invalidRFC")
         b-notification(type="is-danger" :closable="false" :active="invalidRFC" has-icon) {{errorRFC}}
      .column(v-if="!invalidRFC")
        b-field(label="CURP*")
          b-input(
            placeholder="CURP"
            v-model="datos_personales.curp"
            @change="cambiaCurp"
            minlength="18"
            maxlength="18"
            required)
      .column(v-if="!invalidRFC")
        b-field(label="Fecha de nacimiento")
          span {{datos_personales.fecha_nacimiento || 'No Definido'}}

      .column.is-2(v-if="!invalidRFC")
        b-field(label="Sexo*")
          span {{datos_personales.sexo || 'No Definido'}}

    .columns
      .column
        b-field(label="Nombre*")
          b-input(
            placeholder="Nombre"
            v-model="datos_personales.nombre"
            required)
      .column
        b-field(label="Primer apellido")
          b-input(
            placeholder="Primer apellido"
            v-model="datos_personales.primer_apellido")
      .column
        b-field(label="Segundo apellido")
          b-input(
            placeholder="Segundo apellido"
            v-model="datos_personales.segundo_apellido")
    .columns
      .column.is-3
        b-field(label="Forma de pago*")
          b-select(
            v-model="datos_personales.tipo_pago"
            expanded
            required)
            option(v-for="(tp, i) in catalogos.tipo_pago" :value="i") {{tp}}

      .column
        .columns(v-if="datos_personales.tipo_pago == 'TRANSFERENCIA ELECTRÓNICA'")
          .column.is-3
            b-field(label="Banco*")
              b-select(
                v-model="datos_personales.banco"
                placeholder= "Seleccione"
                expanded
                required)
                option(v-for="b in catalogos.bancos" :value="b") {{b}}
          .column
            b-field(label="Número de cuenta bancaria*")
              b-input(
                placeholder="Número de cuenta bancaria"
                v-model="datos_personales.numero_cuenta"
                required)
          .column
            b-field(label="Cuenta CLABE")
              b-input(
                placeholder="Número de cuenta CLABE"
                v-model="datos_personales.clabe")
    .columns
      .column
        b-field(label="NSS")
          b-input(
            placeholder="ISSSTE"
            v-model="datos_personales.nss")
      .column
        b-field(label="Correo electrónico")
          b-input(
            type= "email"
            placeholder="Correo electrónico"
            v-model="datos_personales.correo_electronico")
</template>
<script>
  import Datepicker from 'vuejs-datepicker'
  import { mapState, mapActions } from 'vuex'
  import moment from 'moment'

  export default {
    name: 'Datosdatos_personalesesForm',
    props: ['datos_personales', 'id'],
    components: {
      Datepicker
    },
    data () {
      return {
        isLoadingEmpleado: false,
        invalidRFC: false,
        errorRFC: ''
      }
    },
    computed: {
      ...mapState([
        'catalogos'
      ])
    },
    methods: {
      cambiaCurp: function () {
        let sexo = ''
        if (this.datos_personales.curp.length === 18) {
          sexo = this.datos_personales.curp.substr(10, 1)
          this.$set(this.datos_personales, 'sexo', sexo.toLowerCase() === 'h' ? 'HOMBRE' : 'MUJER')
        }
      },
      ...mapActions({
        getEmpleado: 'empleados/getEmpleado'
      })
    },
    watch: {
      'datos_personales.rfc': {
        handler (value) {
          value = value.toUpperCase()
          const regex = /^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})$/
          if (value.length === 13) {
            if (regex.test(value)) {
              this.invalidRFC = false
              let fecha = value.substr(4, 6)
              let fechaStr = fecha.substr(0, 2) + '/' + fecha.substr(2, 2) + '/' + fecha.substr(4, 2)
              if (Date.parse(fechaStr, 'd/M/yy')) {
                let fechaObj = new Date(fechaStr)
                this.$set(this.datos_personales, 'fecha_nacimiento', moment(fechaObj).format('YYYY-MM-DD'))
              } else {
                this.$set(this.datos_personales, 'fecha_nacimiento', null)
                this.invalidRFC = true
                this.errorRFC = 'No contiene una fecha de nacimiento valida.'
              }

              // inicializa el CURP
              const curp = this.datos_personales.curp ? this.datos_personales.curp.substr(10, 8) : ''
              const original = this.datos_personales.curp ? this.datos_personales.curp.substr(0, 10) : ''
              if (value.substr(0, 10) !== original) {
                this.$set(this.datos_personales, 'curp', value.substr(0, 10) + curp.toUpperCase())
              }

              // se busca en el API de acurdo al RFC ingresado
              if (!this.datos_personales.id) {
                this.isLoadingEmpleado = true
                this.getEmpleado([value, 'rfc']).then((result) => {
                  this.isLoadingEmpleado = false
                  if (result) {
                    delete result.datos_personales.rfc
                    Object.assign(this.datos_personales, result.datos_personales)
                    this.$toast.open({
                      duration: 5000,
                      message: `Se ha cargado los datos personales ya existentes en la base de datos.`,
                      position: 'is-top-right',
                      type: 'is-info'
                    })
                  }
                }, (error) => {
                  this.isLoadingEmpleado = false
                  this.$toast.open({
                    duration: 5000,
                    message: error.error,
                    position: 'is-top-right',
                    type: 'is-danger'
                  })
                })
              }
            } else {
              this.invalidRFC = true
              this.errorRFC = 'Formato no valido.'
            }
          } else {
            this.isLoadingEmpleado = false
          }
        }
      },
      'datos_personales.curp': {
        handler (value) {
          if (value.length === 18) {
            let sexo = value.substr(10, 1)
            this.$set(this.datos_personales, 'sexo', sexo.toLowerCase() === 'h' ? 'HOMBRE' : 'MUJER')
          }
        }
      }
    }
  }
</script>
