<template lang="pug">
  section.empleados
    encabezado-nomina(:nomina = 'nomina')
    
    .columns
      .column
        h4.title.is-4
          span(v-if="selected.length > 0") Elementos seleccionados: {{selected.length}}
          span(v-else) Seleccione los elementos a agregar
      .column.is-right(v-if="selected.length > 0")
        button.button.is-danger.is-outlined(@click="selected=[]")
          span.icon
            b-icon(icon='trash')
          span Limpiar selección
        |  
        button.button.is-success.is-outlined(@click="add")
          span.icon
            b-icon(icon='user-plus')
          span Agregar
          
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
      :checked-rows.sync="selected"
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
import { mapState, mapActions, mapGetters } from 'vuex'
import StatusLabel from '@/components/empleados/partials/StatusLabel'
import EncabezadoNomina from '../Encabezado'
export default {
  name: 'AgregarEmpleados',
  components: {
    StatusLabel,
    EncabezadoNomina
  },
  data () {
    return {
      nominaFilter: {
        status_text: 'ACTIVO'
      },
      id: 0,
      selected: [],
      includes: []
    }
  },
  computed: {
    ...mapState(['catalogos', 'empleados']),
    ...mapGetters({
      getNominaById: 'nominas/getNominaById'
    }),
    nomina () {
      return this.getNominaById(this.id)
    },
    avalibleEmpleados: function () {
      const keys = Object.keys(this.nominaFilter)
      return this.empleados.empleados.filter((emp) => {
        let found = true
        if (this.includes.indexOf(emp.id) >= 0) {
          return false
        }
        keys.forEach(key => {
          if (found && this.nominaFilter[key] != null) {
            let value = emp[key]
            if (key === 'nombre_completo' || key === 'rfc') {
              value = emp['datos_personales'][key]
            } else {
              if (!value.includes(this.nominaFilter[key].toUpperCase())) {
                found = false
              }
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
    }),
    // agregar
    add () {
      this.$dialog.confirm({
        title: 'Agregar selección',
        message: '¿Estas seguro de continuar?',
        cancelText: 'Cancelar',
        confirmText: 'Continuar',
        onConfirm: () => this.$toast.open('User confirmed')
      })
    }
  },
  mounted () {
    // actualiza el catalogo de empleados
    this.getAllEmpleados()
    this.id = this.$route.params.id
    this.getNomina({ id: this.id }).then(
      (res) => {
        this.$set(this.nominaFilter, 'tipo_contrato', res.tipo_nomina.tipo_empleado)
        let includes = res.desglose.map((e) => e.empleado_id)
        this.$set(this, 'includes', includes)
      }
    )
  }
}
</script>
