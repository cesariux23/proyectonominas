<template lang="pug">
  .DatosPersonales
    h4.title.is-4 Datos personales
    hr
    .columns
      .column.is-4
        b-field(label="RFC*")
          b-input(
            placeholder="RFC, mínimo 10 caracteres"
            v-model="datos_personales.rfc"
            minlength="10"
            maxlength="13"
            required)
      .column
         b-notification(type="is-danger" :closable="false" :active="invalidRFC" has-icon) El RFC ingresado no es valido. 
    .columns
      .column
        b-field(label="CURP*")
          b-input(
            placeholder="CURP"
            v-model="datos_personales.curp"
            @change="cambiaCurp"
            minlength="18"
            maxlength="18"
            required)
      .column
        b-field(label="Fecha de nacimiento")
          input.input(
            type="date"
            v-model="datos_personales.fecha_nacimiento"
            tabindex = '200'
            required)
              
      .column.is-2
        b-field(label="Sexo*")
          b-select(
            placeholder="Sexo"
            v-model="datos_personales.sexo"
            tabindex = '201'
            expanded
            required)
            option(value="MUJER") MUJER
            option(value="HOMBRE") HOMBRE

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
    .columns
      .column
        b-field(label="Forma de pago*")
          b-select(
            v-model="datos_personales.tipo_pago"
            expanded
            required)
            option(v-for="(tp, i) in catalogos.tipo_pago" :value="i") {{tp}}

      .column
        .columns(v-if="datos_personales.tipo_pago == 'DEPOSITO'")
          .column.is-4
            b-field(label="Banco*")
              b-select(
                v-model="datos_personales.banco"
                placeholder= "Seleccione"
                expanded
                required)
                option(v-for="b in catalogos.bancos" :value="b") {{b}}
          .column
            b-field(label="Número de cuenta bancaria")
              b-input(
                placeholder="Número de cuenta bancaria"
                v-model="datos_personales.numero_cuenta")
</template>
<script>
  import Datepicker from 'vuejs-datepicker'
  import { mapState } from 'vuex'
  import moment from 'moment'

  export default {
    name: 'Datosdatos_personalesesForm',
    props: ['datos_personales'],
    components: {
      Datepicker
    },
    data () {
      return {
        buscandoRFC: false,
        invalidRFC: false
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
      cambiaRfc: function () {
        this.buscandoRFC = true
        // Se valida la longitud para poder procesar
        if (this.datos_personales.rfc.length >= 10) {
          // se busca en la base de datos
          var self = this
          this.$io.socket.get('/personal', {rfc: this.datos_personales.rfc}, function (data) {
            if (data[0]) {
              self.datos_personales = data[0]
            }
            self.buscandoRFC = false
          })

          // se genera la fecha de nacimiento a partir del rfc
          let fechaNacimiento = this.datos_personales.rfc.substr(4, 6)
          let fecha = new Date(fechaNacimiento.substr(0, 2), fechaNacimiento.substr(2, 2) - 1, fechaNacimiento.substr(4, 2))
          this.$set(this.datos_personales, 'fecha_nacimiento', fecha)

          console.log(fecha)
          // this.$set(this.personal, 'sexo', sexo.toLowerCase() === 'h' ? 'HOMBRE' : 'MUJER')
        }
      }
    },
    watch: {
      'datos_personales.rfc': {
        handler (value) {
          value = value.toUpperCase()
          const regex = /^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$/
          if (value.length >= 10) {
            if (regex.test(value)) {
              this.invalidRFC = false
              let fecha = value.substr(4, 6)
              if (Number.isInteger(parseInt(fecha))) {
                let fechaStr = fecha.substr(0, 2) + '/' + fecha.substr(2, 2) + '/' + fecha.substr(4, 2)
                if (Date.parse(fechaStr, 'd/M/yy')) {
                  let fechaObj = new Date(fechaStr)
                  console.log(moment(fechaObj).format('yyyy-MM-dd'))
                  this.$set(this.datos_personales, 'fecha_nacimiento', moment(fechaObj).format('YYYY-MM-DD'))
                } else {
                  this.$set(this.datos_personales, 'fecha_nacimiento', null)
                  this.invalidRFC = true
                }
              } else {
                this.$set(this.datos_personales, 'fecha_nacimiento', null)
                this.invalidRFC = true
              }

              // inicializa el CURP
              let curp = this.datos_personales.curp ? this.datos_personales.curp.substr(10, 8) : ''
              this.$set(this.datos_personales, 'curp', value.substr(0, 10) + curp.toUpperCase())
            } else {
              this.invalidRFC = true
            }
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
