<template>
  <div class="EditarEmpleado">
    <b-loading :active.sync="isLoading"/>
    <div class="columns">
      <div class="column">
        <router-link :to="{ name: 'detalleEmpleado', params: {id: empleado.id}}" class="button is-info is-outlined is-medium" title="Volver al listado de empleados">
          <span class="icon"><i class="fa fa-arrow-left"></i></span>
        </router-link>
        <h1 class="title is-inline">
          Editar información del empleado
        </h1>
      </div>
    </div>
    <form class="" :action="url" method="put">
      <formulario-empleado :empleado="empleado" :editable="editable"></formulario-empleado>
      <br>
      <button type="button" name="button" class="button is-success" v-on:click="guardar()">Guardar cambios</button>
    </form>
  </div>
</template>

<script>
import FormularioEmpleado from './FormularioEmpleado'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'EditarEmpleado',
  components: {
    FormularioEmpleado
  },
  data () {
    return {
      isLoading: false,
      empleado: {
        datos_personales: {},
        puesto_actual: {},
        fechaInicio: ''
      },
      editable: {},
      url: ''
    }
  },
  methods: {
    updateEmpleadoData () {
      this.empleado = this.getEmpleadoById(this.id) || this.empleado
      this.isLoading = true
      this.getEmpleado(this.id).then((result) => {
        this.isLoading = false
        this.empleado = result
      }, (error) => {
        this.isLoading = false
        this.$router.push('/empleados')
        this.$toast.open({
          duration: 5000,
          message: error.data.error,
          position: 'is-top-right',
          type: 'is-danger'
        })
      })
    },
    guardar () {
      this.$dialog.confirm({
        title: 'Confirmar acción',
        message: `¿Deseas actualizar los datos del empleado <b>
        ${this.empleado.datos_personales.nombre}
        ${this.empleado.datos_personales.primer_apellido}
        ${this.empleado.datos_personales.segundo_apellido}</b>? `,
        confirmText: 'Guardar cambios',
        cancelText: 'Cancelar',
        type: 'is-info',
        hasIcon: true,
        onConfirm: () => {
          // Se guarda el nuevo status en la base de datos
          this.updateEmpleado({id: this.id, data: this.empleado}).then((response) => {
            this.$router.push('/empleados/' + this.id)
            this.$toast.open({
              duration: 10000,
              message: `Se ha actualizado la información correctamente.`,
              position: 'is-top-right',
              type: 'is-success'
            })
          }, (error) => {
            this.$toast.open({
              duration: 5000,
              message: error.data.error,
              position: 'is-top-right',
              type: 'is-danger'
            })
          })
        }
      })
    },
    ...mapActions({
      getEmpleado: 'empleados/getEmpleado',
      updateEmpleado: 'empleados/updateEmpleado'
    })
  },
  computed: {
    ...mapGetters({
      getEmpleadoById: 'empleados/getEmpleadoById'
    })
  },
  mounted: function () {
    this.id = this.$route.params.id
    const partial = this.$route.params.partial
    this.$set(this.editable, partial, true)
    this.updateEmpleadoData()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
