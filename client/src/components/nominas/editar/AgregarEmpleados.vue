<template lang="pug">
  section.empleados
    br
    h4.title.is-4 Incluir empleados
    
    .columns
      .column
        b-field(label="RFC")
          b-input(v-model="nominaFilter.rfc")
      .column
        b-field(label="Nombre")
          b-input(v-model="nominaFilter.nombre_completo")       
      .column
          b-field(label='Status')
            b-field
              b-select(
                v-model="nominaFilter.status_text"
                placeholder="- TODOS -"
                expanded)
                option(v-for="(o, k) in catalogos.status" :value="k") {{k}}
              button.button.is-danger(@click= "nominaFilter.status_text = null")
                b-icon(icon='times')
    b-table(
      :data="avalibleEmpleados"
      :loading="empleados.isLoadingEmpleadosList"
      checkable
      )
      template(slot-scope="props")
        b-table-column(label="No. Emp." width="100" string)
          | {{ props.row.numero_empleado }}
        b-table-column(field="datos_personales.rfc" label="Empleado" string sortable)
          |{{ props.row.datos_personales.nombre_completo }}
          br
          b {{ props.row.datos_personales.rfc }}
        b-table-column(label="Ascripción" string)
          | {{ props.row.puesto_actual ? props.row.puesto_actual.adscripcion.nombre : '--' }}
        b-table-column(label="Contrato" string)
          | {{ props.row.tipo_contrato }}
        b-table-column(label="Estatus" string)
          status-label(:status='props.row.status')
</template>
<script>
import { mapState, mapActions } from 'vuex'
import StatusLabel from '@/components/empleados/partials/StatusLabel'
export default {
  name: 'AgregarEmpleados',
  components: {
    StatusLabel
  },
  data () {
    return {
      nominaFilter: {}
    }
  },
  computed: {
    ...mapState(['catalogos', 'empleados']),
    avalibleEmpleados: function () {
      const keys = Object.keys(this.nominaFilter)
      return this.empleados.empleados.filter((emp) => {
        let found = true
        keys.forEach(key => {
          console.log('key:' + key)
          if (found && this.nominaFilter[key] != null) {
            let value = emp[key]
            if (key === 'nombre_completo' || key === 'rfc') {
              value = emp['datos_personales'][key]
            }
            if (!value.includes(this.nominaFilter[key].toUpperCase())) {
              found = false
            }
          }
        })
        return found
      })
    }
  },
  methods: {
    ...mapActions({
      getAllEmpleados: 'empleados/fetchEmpleados',
      getNomina: 'nominas/getNomina'
    })
  },
  mounted () {
    // actualiza el catalogo de empleados
    this.getAllEmpleados()
    this.id = this.$route.params.id
    this.getNomina(this.id).then((response) => {
      this.nomina = response
    }, (error) => {
      this.$toast.open({
        duration: 5000,
        message: error.data.error,
        position: 'is-top-right',
        type: 'is-danger'
      })
    })
  }
}
</script>
