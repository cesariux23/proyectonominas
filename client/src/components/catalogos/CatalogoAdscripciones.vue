<template lang="pug">
  .CatalogoAdscripciones
    .columns
      .column
        h3.title.is-3 Catálogo Adscripciones
      .column.is-4
        button.button.is-primary.is-pulled-right(type="button" v-if="!selected" @click="showModal = true")
          b-icon(icon="plus")
          span Agregar
        .field.is-grouped.is-pulled-right(v-if="selected")
          p.control
            button.button.is-danger(type="button" @click="selected = null")
              b-icon(icon="times")
              span Limpiar selección
          p.control
            button.button.is-info(type="button" @click="showModal = true")
              b-icon(icon="pencil")
              span Editar
    b-table(
      :data= "catalogos.adscripciones"
      :selected.sync="selected"
      :loading.sync="isLoading"
      )
      template(slot-scope="props")
        b-table-column(label="ID" width="50" numeric)
          | {{ props.row.id }}
        b-table-column(label="Unidad" string)
          | {{ props.row.unidad || '---' }}
        b-table-column(label="Subunidad" string)
          | {{ props.row.subunidad || '00'}}
        b-table-column(label="Adscripción" string)
          | {{ props.row.nombre }}
    b-modal(:active.sync="showModal"
      has-modal-card)
        form(@submit.prevent="guardar")
          .modal-card
            .modal-card-head
              .modal-card-title {{selected ? 'Editar' : 'Registrar'}} adscripción
            .modal-card-body
              .content
                .columns
                  .column
                    b-field(label="Nombre")
                      input.input(
                        v-model='adscripcion.nombre'
                        required)
                  .column.is-2
                    b-field(label="Activa")
                      b-switch(v-model="adscripcion.activa"
                        true-value= 1
                        false-value= 0)
                .columns
                  .column
                    b-field(label="Unidad presupuestal") 
                      input.input(
                        v-model='adscripcion.unidad_presupuestal'
                        required)
                  .column.is-3
                    b-field(label="Unidad") 
                      input.input(
                        v-model='adscripcion.unidad')
                  .column.is-3
                    b-field(label="Subunidad")
                      input.input(
                        v-model='adscripcion.subunidad')

            .modal-card-foot
                button.button.is-danger(type="button" @click="showModal = false")
                  b-icon(icon="times")
                  span Cancelar
                button.button.is-primary(type="submit")
                  b-icon(icon="check")
                  span {{selected ? 'Guardar cambios' : 'Registrar adscripción'}}
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  name: 'CatalogoAdscripciones',
  data () {
    return {
      selected: null,
      showModal: false,
      isLoading: false,
      adscripcion: {}
    }
  },
  computed: {
    ...mapState(['catalogos'])
  },
  methods: {
    guardar () {
      this.showModal = false
      this.selected = null
      if (this.adscripcion.id) {

      } else {
        this.saveAdscripcion(this.adscripcion).then((res) => {
          this.$toast.open({
            duration: 5000,
            message: 'Adscripción guardada correctamente.',
            position: 'is-top-right',
            type: 'is-success'
          })
        }, (error) => {
          this.$toast.open({
            duration: 5000,
            message: error.data.error,
            position: 'is-top-right',
            type: 'is-success'
          })
        })
      }
    },
    ...mapActions(['saveAdscripcion'])
  },
  watch: {
    'showModal': {
      handler (value) {
        if (value) {
          if (this.selected) {
            this.$set(this, 'adscripcion', JSON.parse(JSON.stringify(this.selected)))
          } else {
            this.$set(this, 'adscripcion', {activa: 1})
          }
        }
      }
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
