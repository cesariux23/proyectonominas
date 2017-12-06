<template lang="pug">
  .CatalogoNominas
    .columns
      .column
        h3.title.is-3 CATÁLOGO DE NOMINAS
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
      :data= "catalogos.tipo_nomina"
      :selected.sync="selected"
      )
      template(slot-scope="props")
        b-table-column(label="ID" width="50" numeric)
          | {{ props.row.id }}
        b-table-column(label="Descripción" string)
          | {{ props.row.descripcion }}
        b-table-column(label="Tipo  de empleado" string)
          | {{ props.row.tipo_empleado || 'Cualquiera'}}
    b-modal(:active.sync="showModal"
      has-modal-card)
        form(@submit.prevent="guardar")
          .modal-card
            .modal-card-head
              .modal-card-title {{selected ? 'Editar' : 'Registrar'}} nomina
            .modal-card-body
              .content
                .columns
                  .column
                    b-field(label="Descripción")
                      input.input(
                        v-model='nomina.descripcion'
                        required)
                .columns
                  .column
                    b-field(label="tipo de empleado") 
                      input.input(
                        v-model='nomina.tipo_empleado'
                        placeholder='Cualquier tipo'
                      )
                  .column.is-2
                    b-field(label="Activa")
                      b-switch(v-model="nomina.activa"
                        true-value= 1
                        false-value= 0)
            .modal-card-foot
                button.button.is-danger(type="button" @click="showModal = false")
                  b-icon(icon="times")
                  span Cancelar
                button.button.is-primary(type="submit")
                  b-icon(icon="check")
                  span {{selected ? 'Guardar cambios' : 'Registrar nomina'}}
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    name: 'CatalogoNominas',
    data () {
      return {
        showModal: false,
        selected: null,
        nomina: {
          activa: 1
        }
      }
    },
    computed: {
      ...mapState(['catalogos'])
    }
  }
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
