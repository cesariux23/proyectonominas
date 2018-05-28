<template lang="pug">
  .StatusLabel
    b-tooltip(:label="tooltip")
      div(v-if="editable")
        b-dropdown(
          v-model="internalStatus"
          position="is-bottom-left"
          :disabled='!availableStatuses'       
          )
          button.button(slot="trigger" :class="_class(currentStatus)")
            span
              b Status:  
              |   {{currentStatus}}
            b-icon(icon="chevron-down")
          b-dropdown-item(:value="st.value" v-for=" st in availableStatuses" :key="st.value")
            b-icon(:icon="st.icon")
            | {{st.value}}
        
        // Modal para modificación de estatus
        b-modal(:active.sync ='showModal' v-if="internalStatus"
          has-modal-card)
          form(@submit.prevent="cambiarStatus")
            .modal-card
              .modal-card-head
                .modal-card-title 
                  b-icon(:icon='statusData[internalStatus].icon')
                  | {{internalStatus}}  
                button.delete(type="button" aria-label="close" @click="showModal = false")
              .modal-card-body
                .content
                  b-field(label="Seleccione un estatus" v-if="substatus")
                    b-select(
                      placeholder="Seleccione un estatus"
                      v-model="nuevo_status.substatus"
                      expanded
                      required)
                      option(v-for="s in substatus" :value="s") {{internalStatus + ' ' + s}}
                  .columns
                    .column(v-for="rf in _status.required")
                      b-field(:label="_label(rf)+'*'")
                        input.input(
                          type="date"
                          v-model='nuevo_status[rf]'
                          required)
                    .column(v-for="of in _status.optional")
                      b-field(:label="_label(of)")
                        input.input(
                          type="date"
                          v-model='nuevo_status[of]')
                  .columns
                    .column
                      b-field(label="Observaciones")
                        input.input(
                          type="text"
                          v-model='nuevo_status.observaciones')
              .modal-card-foot
                  button.button.is-danger(type="button" @click="showModal= false")
                    b-icon(icon="times")
                    span Cancelar
                  button.button.is-primary(type="submit")
                    b-icon(icon="check")
                    span Cambiar status
      b-tag(v-else
        :type="_class(currentStatus)")
        | {{currentStatus}}
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  name: 'StatusLabel',
  props: ['status', 'id', 'editable'],
  data () {
    return {
      internalStatus: false,
      showModal: false,
      nuevo_status: {},
      statusData: {
        ACTIVO: {
          value: 'ACTIVO',
          class: 'is-success',
          icon: 'check-circle',
          excluede: true,
          antiguedad: null
        },
        'LICENCIA MEDICA': {
          value: 'LICENCIA MEDICA',
          class: 'is-info',
          icon: 'plus-circle',
          antiguedad: false // al generar el recuento de la antiguedad, seran descontados
        },
        'LICENCIA LABORAL': {
          value: 'LICENCIA LABORAL',
          class: 'is-info',
          icon: 'pause-circle',
          antiguedad: false
        },
        'BAJA': {
          value: 'BAJA',
          class: 'is-danger',
          icon: 'minus-circle',
          antiguedad: null,
          none: true // Ya no se puede reactivar una baja definitiva
        }
      }
    }
  },
  computed: {
    currentStatus () {
      return typeof this.status === 'object' ? this.status.status : this.status
    },
    _status () {
      return this.catalogos.status[this.internalStatus] || {}
    },
    substatus () {
      if (this.internalStatus) {
        return this._status.substatus || false
      }
      return false
    },
    availableStatuses () {
      // se elimina los estatus que no pueden ser seleccionados a partir del estatus actual
      let statuses = {}
      const _status = this.statusData[this.currentStatus]
      Object.assign(statuses, this.statusData)
      if (_status && _status.excluede) {
        delete statuses[this.currentStatus] // se elimina el status actual
      }
      if (_status && _status.none) {
        return false
      }
      return statuses
    },
    tooltip () {
      const _status = this.status
      return _status.status + ' ' + _status.substatus
    },
    ...mapState([
      'catalogos'
    ])
  },
  methods: {
    _class (status) {
      if (status) {
        return this.statusData[status].class
      }
    },
    _label (text) {
      const _text = text.split('_')
      if (text.length > 0) {
        return _text.join(' de ')
      }
      return text
    },
    // almacenamiento del status
    cambiarStatus () {
      this.$dialog.confirm({
        title: 'Confirmar Acción',
        message: `Cambio de estatus:
                  </br>
                  <b>${this.currentStatus}</b>
                  <i class="fa fa-arrow-right"></i>
                  <b> ${this.internalStatus}</b>`,
        confirmText: 'Cambiar',
        cancelText: 'Cancelar',
        type: 'is-info',
        hasIcon: true,
        onConfirm: () => {
          this.showModal = false
          const data = {status: this.nuevo_status}
          // se verifica la fecha de baja
          if (this.nuevo_status.fecha_baja) {
            data.fecha_baja = this.nuevo_status.fecha_baja
            data.status.fecha_inicio = this.nuevo_status.fecha_baja
            delete data.status.fecha_baja
          }
          // Se guarda el nuevo status en la base de datos
          this.updateEmpleado({id: this.id, data}).then((response) => {
            this.$toast.open({
              duration: 5000,
              message: `Se cambio el status correctamente.`,
              position: 'is-top-right',
              type: 'is-success'
            })
          })
        }
      })
    },
    ...mapActions({
      updateEmpleado: 'empleados/updateEmpleado'
    })
  },
  watch: {
    internalStatus (value) {
      this.nuevo_status = {
        status: value,
        antiguedad: this.statusData[value].antiguedad
      }
      if (this.internalStatus !== this._status) {
        this.showModal = true
      }
    }
  }
}
</script>

