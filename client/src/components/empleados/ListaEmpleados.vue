<template lang="pug">
  .ListaEmpleados
    .columns
      .column
        h1.title Empleados
      .column.is-2.is-right
        router-link(to="empleados/new" class="button is-primary" title="Realizar alta de un nuevo empleado")
          span.icon
            i.fa.fa-user-plus
          span Alta
    section
      b-table(:data="isEmpty ? [] : empleados" :loading="isLoading")
        template(slot-scope="props")
          b-table-column(label="ID" width="50" numeric)
            | {{ props.row.id }}
          b-table-column(label="No. Empleado" string)
            | {{ props.row.numero_empleado }}
          b-table-column(field="datos_personales.rfc" label="RFC" string sortable)
            | {{ props.row.datos_personales.rfc }}
          b-table-column(label="Nombre" string)
            | {{ props.row.datos_personales.nombre_completo }}
          b-table-column(label="Contrato" string)
            | {{ props.row.tipo_contrato }}
          b-table-column(label="Ascripción" string)
            | {{ props.row.tipo_contrato }}
          b-table-column(label="Acciones" string)
            .field.has-addons
              p.control
                router-link(:to="{ path: 'empleados/'+props.row.id }" class="button is-primary is-outlined" title="Ver detalles")
                  i.fa.fa-user
              p.control
                router-link(:to="{ name:'empleadoEdit', params:{id: props.row.id}}" class="button is-info is-outlined" title="Editar información")
                  i.fa.fa-pencil

</template>
<script>
// import { addEmpleado } from '../../vuex/actions'
// import { getPersonal } from '../../vuex/getters'
export default {
  name: 'ListaEmpleados',
  // vuex: {
  //   getters: {
  //     empleados: getPersonal
  //   },
  //   actions: {
  //     addEmpleado
  //   }
  // },
  data () {
    return {
      empleados: [],
      isLoading: false,
      isEmpty: true
    }
  },
  methods: {
    getEmpleados: function () {
      this.isLoading = true
      var self = this
      this.$io.socket.get('/empleado', {status: 'ACTIVO'}, function (data) {
        self.isEmpty = false
        self.isLoading = false
        self.empleados = data
        console.log(data)
      })
    }
  },
  mounted: function () {
    this.getEmpleados()
    // this.fetchEmpleados()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
