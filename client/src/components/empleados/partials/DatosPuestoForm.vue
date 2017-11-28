<template lang="pug">
  .Datospuesto_actual
    .columns.in(v-if="tipo_contrato != 'HONORARIOS'")
      .column
        label.label Clave de la plaza*
        .field.has-addons
          p.control.is-expanded
            input.input(type="text" placeholder="Clave de la plaza" v-model="plaza.clave")
          p.control
            a.button.is-info(type="button" @click="showPlazas = true")
              span.icon
                i.fa.fa-search
      .column.is-6
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
          b-field(label="Fecha de inicio*")
            input.input(
              type="date"
              v-model="puesto_actual.fecha_inicio"
              required)
    b-modal(:active.sync="showPlazas"
    has-modal-card)
      .modal-card
        .modal-card-head
          .modal-card-title Seleccione
          button.delete(type="button" aria-label="close" @click="showPlazas = false")
        .modal-card-body
          .content
            b-table(
              :data= "plazas"
              :selected.sync = "plazaSelected"
              )
              template(slot-scope="props")
                b-table-column(label="ID" width="50" numeric)
                  | {{ props.row.id }}
                b-table-column(label="Clave" width="50" string)
                  | {{ props.row.clave }}
                b-table-column(label="Tipo" width="100" string)
                  | {{ props.row.tipo }}
                b-table-column(label="Nombre" string)
                  | {{ props.row.nombre }}
                b-table-column(label="Nivel" width="50" string)
                  | {{ props.row.nivel }}
                b-table-column(label="Zona" width="50" numeric)
                  | {{ props.row.zona }}
        .modal-card-foot
            button.button.is-danger(type="button" @click="plazaSelected = null") Limpiar selección
            button.button(type="button" @click="showPlazas = false") OK

</template>
<script>
  import { mapState } from 'vuex'
  export default {
    name: 'Datospuesto_actualForm',
    data () {
      return {
        adscripciones: [],
        plaza: {},
        plazaSelected: {},
        showPlazas: false
      }
    },
    computed: {
      ...mapState({
        plazas (state) {
          if (state.catalogos.plazas) {
            return state.catalogos.plazas.filter(plaza => plaza.tipo === this.tipo_contrato)
          }
          return []
        },
        plaza_selecccionada (state) {
          return this.plazas.find(p => p.clave === this.plaza.clave)
        }
      }),
      ...mapState([
        'catalogos'
      ])
    },
    watch: {
      'showPlazas': {
        handler (value) {
          if (value) {
            // si ya existe una plaza valida, se marca como selecionada
            // this.$set('plazaSelected', this.plaza_selecccionada)
          } else {
            if (this.plazaSelected && this.plazaSelected.hasOwnProperty('clave')) {
              this.$set(this.plaza, 'clave', this.plazaSelected.clave)
            } else {
              this.$set(this.plaza, 'clave', '')
            }
          }
        }
      },
      'plaza_selecccionada': {
        handler (value) {
          if (value) {
            this.$set(this.puesto_actual, 'plaza_id', value.id)
          } else {
            this.$set(this.puesto_actual, 'plaza_id', null)
          }
        }
      },
      'tipo_contrato': {
        handler (value) {
          this.$set(this.plaza, 'clave', '')
        }
      }
    },
    props: ['puesto_actual', 'tipo_contrato'],
    methods: {
    }
  }
</script>
