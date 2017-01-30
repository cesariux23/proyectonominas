<template>
  <div class="Empleados">
    <div class="columns">
      <div class="column">
        <h1 class="title">EMPLEADOS</h1>
      </div>
      <div class="column is-2">
        <router-link to="empleados/new" class="button is-primary">
          <span class="icon"><i class="fa fa-user-plus"></i></span>
          <span>Registrar empleado</span>
        </router-link>
      </div>
    </div>
    <hr>
    <section>
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
import ListaEmpleados from './empleados/ListaEmpleados'
export default {
  name: 'Empleados',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
  components: {
    ListaEmpleados
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.Empleados{
  height: auto;
}

aside{
  float: left;
  height: 100%;
}
</style>
