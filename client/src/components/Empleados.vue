<template>
  <div class="Empleados">
    <router-view></router-view>
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
