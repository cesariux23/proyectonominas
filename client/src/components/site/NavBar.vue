<template>
  <div class="nav-bar">
    <nav class="nav has-shadow">
      <div class="nav-left">
        <span class="nav-item">RECURSOS <b>HUMANOS</b></span>
        <router-link :to="{name: 'indexEmpleados'}" active-class="is-active" class="nav-item is-tab">Empleados</router-link>
        <router-link to="/nominas" active-class="is-active" class="nav-item is-tab">Nóminas</router-link>
        <router-link to="/catalogos" active-class="is-active" class="nav-item is-tab">Catálogos</router-link>
      </div>
      <span class="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
      </span>
      <div class="nav-menu">
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link" href="#">
            <b-icon icon="user"></b-icon> {{user.name || user.username || 'Usuario'}}
          </a>
          <div class="navbar-dropdown is-boxed">
            <a class="navbar-item" role="button" @click="logout">
              <b-icon icon="power-off"></b-icon>
              <span>Salir</span>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
  name: 'NavBar',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
  methods: {
    logout () {
      this.clearToken()
      this.clearUser()
      this.$router.push('/login')
    },
    ...mapMutations([
      'clearToken',
      'clearUser'
    ])
  },
  computed: {
    ...mapState([
      'user'
    ])
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
