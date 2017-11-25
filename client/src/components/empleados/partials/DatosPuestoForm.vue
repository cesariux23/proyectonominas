<template lang="pug">
  .Datospuesto_actual
    .columns.in(v-if="tipo_contrato != 'HONORARIOS'")
      .column
        label.label Clave de la plaza
        .field.has-addons
          p.control.is-expanded
            input.input(type="text" placeholder="Clave de la plaza" v-model="plaza.clave")
          p.control
            a.button.is-info
              span.icon
                i.fa.fa-search
      .column.is-6
        | {{plazas}}
        .notification.is-success(v-if="plaza_selecccionada") {{plaza_selecccionada.nombre}}
        .notification.is-warning(v-if="!plaza_selecccionada") Especifique una clave valida
    .columns
      .column
        b-field(label="Función*")
          b-input(
            placeholder="Nombre del puesto o función que desempleña en el Instituto"
            v-model="puesto_actual.funcion"
            required)
       
    .columns
      .column
        b-field(label="Adscripción*")
          b-select(
            v-model="puesto_actual.adscripcion_id"
            expanded
            required)
            option(v-for="a in catalogos.adscripciones" :value="a.id") {{a.nombre}}
      .column
        p.control
          b-field(label="Fecha de inicio")
            b-datepicker(
              v-model="puesto_actual.fecha_inicio"
              placeholder="Seleccione una fecha"
              icon="calendar-today"
              required  )
              button.button.is-danger(type="button" @click="puesto_actual.fecha_inicio = null")
                span Limpiar
</template>
<script>
  import { mapState } from 'vuex'
  export default {
    name: 'Datospuesto_actualForm',
    data () {
      return {
        adscripciones: [],
        plaza: {}
      }
    },
    computed: {
      ...mapState({
        plazas (state) {
          return state.catalogos.plazas.filter(plaza => plaza.tipo === this.tipo_contrato)
        },
        plaza_selecccionada (state) {
          return this.plazas.find(p => p.clave === this.plaza.clave)
        }
      }),
      ...mapState([
        'catalogos'
      ])
    },
    props: ['puesto_actual', 'tipo_contrato'],
    methods: {
      getAdscripciones: function () {
        var self = this
        this.$io.socket.get('/adscripcion', function (data) {
          self.adscripciones = data
        })
      }
    },
    mounted: function () {
      this.getAdscripciones()
    }
  }
</script>
