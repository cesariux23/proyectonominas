<template lang="pug">
  .ListaEmpleados
    .columns
      .column
        h1.title Empleados
      .column.is-2.is-right
        router-link(:to="{name: 'registroEmpleado'}" class="button is-primary" title="Realizar alta de un nuevo empleado")
          span.icon
            i.fa.fa-user-plus
          span Alta
    section
      b-table(
          :data="isEmpty ? [] : empleados"
          :loading="isLoadingEmpleadosList"
          paginated=true
          per-page=10
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
          b-table-column(label="Acciones" string)
            .field.has-addons
              p.control
                router-link(:to="{ name: 'detalleEmpleado', params:{id: props.row.id }}" class="button is-primary is-outlined" title="Ver detalles")
                  i.fa.fa-user
              p.control
                router-link(:to="{ name:'empleadoEdit', params:{id: props.row.id, partial: 'datos_personales'}}" class="button is-info is-outlined" title="Editar información")
                  i.fa.fa-pencil
</template>
<script>
import { mapState, mapActions } from 'vuex'
import StatusLabel from './partials/StatusLabel'

export default {
  name: 'ListaEmpleados',
  components: {
    StatusLabel
  },
  data () {
    return {
    }
  },
  computed: {
    isEmpty () {
      return this.empleados.lenght > 0
    },
    ...mapState('empleados', {
      empleados: state => state.empleados,
      isLoadingEmpleadosList: state => state.isLoadingEmpleadosList
    })
  },
  methods: {
    classStatus (status) {
      let _class = 'is-default'
      switch (status) {
        case 'ACTIVO':
          _class = 'is-success'
          break
        case 'LICENCIA':
          _class = 'is-info'
          break
        case 'BAJA':
          _class = 'is-danger'
          break
      }
      return _class
    },
    ...mapActions({
      getAllEmpleados: 'empleados/fetchEmpleados'
    })
  },
  mounted: function () {
    this.getAllEmpleados()
  }
}
</script>

<style scoped>

</style>
