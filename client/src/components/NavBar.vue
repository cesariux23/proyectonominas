<template>
  <div class="nav-bar">
    <nav class="nav has-shadow">
        <div class="nav-left">
          <span class="nav-item"><b>RH</b>NOMINAS</span>
          <router-link to="/empleados" active-class="is-active" class="nav-item is-tab">Empleados</router-link>
          <router-link to="/nominas" active-class="is-active" class="nav-item is-tab">Nominas</router-link>
          <router-link to="/catalogos" active-class="is-active" class="nav-item is-tab">Catálogos</router-link>
        </div>
        <span class="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <div class="nav-right nav-menu">
          <a class="nav-item is-tab">Iniciar Sesión</a>
        </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'NavBar',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: gray;
}
</style>
