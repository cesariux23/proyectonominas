<template lang="pug">
  section.empleados
    .columns
      .column
        h4.title.is-4
          span(v-if="selected.length > 0") Elementos seleccionados: {{selected.length}}
          span(v-else) Seleccione los elementos a agregar
      .column.is-right
        button.button.is-danger.is-outlined(@click="selected=[]" :disabled="selected.length === 0")
          span.icon
            b-icon(icon='trash')
          span Limpiar selección
        |  
        button.button.is-success.is-outlined(@click="add")
          span.icon
            b-icon(icon='check')
          span Aplicar cambios
          
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
              button.button.is-danger(@click= "nominaFilter.status_text = null" v-if="nominaFilter.status_text !== null")
                b-icon(icon='times')
                span Limpiar
    b-table(
      :data="filteredEmpleados"
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
export default {
  name: 'AgregarEmpleados',
  components: {
    StatusLabel
  },
  data () {
    return {
      nomina: {
        tipo_nomina: {
          aplica: []
        }
      },
      nominaFilter: {
        rfc: '',
        status_text: null
      },
      id: 0,
      selected: [],
      avalibleEmpleados: []
    }
  },
  computed: {
    ...mapState(['catalogos', 'empleados']),
    ...mapGetters({
      getNominaById: 'nominas/getNominaById'
    }),
    filteredEmpleados: function () {
      const keys = Object.keys(this.nominaFilter)
      return this.avalibleEmpleados.filter((emp) => {
        let found = true

        //  se eliminan los empleados con un tipo de contratación no pertenecientes al tipo de la nomina
        if (!this.nomina.tipo_nomina.aplica.includes(emp.tipo_contrato)) {
          return false
        }
        keys.forEach(key => {
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
      getNomina: 'nominas/getNomina',
      addEmpleado: 'desgloseNomina/addDesglose'
    }),
    // agregar
    add () {
      this.$dialog.confirm({
        title: 'Aplicar cambios',
        message: '¿Estas seguro de continuar?',
        cancelText: 'Cancelar',
        confirmText: 'Continuar',
        onConfirm: () => {
          let empleados = Object.values(this.selected)
          empleados = empleados.map(e => e.id)
          console.log(empleados)
          this.addEmpleado([this.id, {empleados}]).then(
            (res) => {
              this.$toast.open({
                duration: 5000,
                message: 'Cambios guardados correctamente.',
                position: 'is-bottom-right',
                type: 'is-success'
              })
              this.$router.push({ name: 'desgloseNomina', params: { id: this.id } })
            }
          )
        }
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
        let empleados = res.desglose.map((e) => e.empleado)
        console.log(res)
        empleados = empleados.filter((emp) => {
          //  se eliminan los empleados con un tipo de contratación no pertenecientes al tipo de la nomina
          return res.tipo_nomina.aplica.includes(emp.tipo_contrato)
        })
        this.$set(this, 'avalibleEmpleados', empleados)
        this.$set(this, 'selected', empleados)
        this.$set(this, 'nomina', res)
      }
    )
  }
}
</script>
