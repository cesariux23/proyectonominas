<template>
  <div id="app">
    <header>
      <div class="logo is-hidden-mobile">
        <img src="./assets/logo.png">
      </div>
      <nav-bar></nav-bar>
    </header>
    <div class="main">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { fetchNominas, fetchEmpleados, fetchCatalogoNominas } from './vuex/actions'
import NavBar from './components/NavBar'

export default {
  name: 'app',
  components: {
    NavBar
  },
  vuex: {
    actions: {
      fetchNominas,
      fetchEmpleados,
      fetchCatalogoNominas
    }
  },
  mounted: function () {
    this.fetchNominas()
    this.fetchEmpleados()
    this.fetchCatalogoNominas()
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  display: flex;
  flex-direction: column;
  height: 100%;
}
html, body{
  padding: 0;
  margin: 0;
  height: 100%;
  width: 100%;
  overflow: auto;
}
header{
}
.main{
  height: 100%;
  overflow: auto;
  padding: 20px;
  background-color: #f5f5f5;
}
</style>
