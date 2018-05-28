<template lang="pug">
  .box(v-if="puesto_actual")
    h3.title.is-4 {{title || 'Puesto Actual'}}
    hr
    .columns.in(v-if="tipo_contrato != 'HONORARIOS'")
      .column
        label.label Clave de la plaza*
        b-field
          b-input(
            placeholder="Clave de la plaza"
            v-model="plaza"
            @blur="validaPlaza"
            expanded
          required)
          p.control
            button.button.is-info(type="button" @click="showPlazas = true")
              b-icon(icon="search")
      .column.is-6
        .notification.is-success(v-if="plaza_seleccionada") {{plaza_seleccionada.nombre}}
        .notification.is-warning(v-if="!plaza_seleccionada") Especifique una clave valida
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
            b-input(
              type="date"
              v-model="puesto_actual.fecha_inicio"
              required)
      .column(v-if="fin || false")
        p.control
          b-field(label="Fecha de finalización*")
            b-input(
              type="date"
              v-model="puesto_actual.fecha_fin"
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
        plaza: '',
        plazaSelected: {},
        showPlazas: false,
        init: false
      }
    },
    computed: {
      plazaEmp () {
        if (this.puesto_actual && this.puesto_actual.plaza) {
          return this.puesto_actual.plaza
        }
        return false
      },
      ...mapState({
        plazas (state) {
          if (state.catalogos.plazas) {
            return state.catalogos.plazas.filter(plaza => plaza.tipo === this.tipo_contrato)
          }
          return []
        },
        plaza_seleccionada (state) {
          const plaza = this.plaza ? this.plaza.toUpperCase() : null
          return this.plazas.find(p => p.clave === plaza)
        }
      }),
      ...mapState([
        'catalogos'
      ])
    },
    watch: {
      'plazaSelected': {
        handler (value) {
          if (value) {
            this.$set(this.puesto_actual, 'plaza_id', value.id)
            this.$set(this, 'plaza', value.clave)
          } else {
            this.$set(this.puesto_actual, 'plaza_id', null)
            this.$set(this, 'plaza', '')
          }
        }
      },
      'plaza_seleccionada': {
        handler (value) {
          this.$set(this, 'plazaSelected', value)
          if (value) {
            this.$set(this.puesto_actual, 'plaza_id', value.id)
            this.$set(this, 'plaza', value.clave)
          } else {
            this.$set(this.puesto_actual, 'plaza_id', null)
            this.$set(this, 'plaza', '')
          }
        },
        deep: true
      },
      'tipo_contrato': {
        handler (newVal, oldVal) {
          if (oldVal) {
            this.$set(this, 'plaza', '')
          }
        }
      },
      'plazaEmp': {
        handler (value) {
          if (value && !this.init) {
            this.init = true
            this.$set(this, 'plaza', value.clave)
          }
        }
      }
    },
    props: ['puesto_actual', 'tipo_contrato', 'title', 'fin'],
    methods: {
      validaPlaza () {
        if (!this.puesto_actual.plaza_id) {
          this.plaza = null
        }
      }
    }
  }
</script>
