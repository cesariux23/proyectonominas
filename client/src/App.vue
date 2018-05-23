<template>
  <div id="app">
    <header  v-if="isAuthenticated">
      <div class="logo is-hidden-mobile">
        <img src="./assets/logo.png">
      </div>
      <nav-bar></nav-bar>
    </header>
    <section class="section">
      <div class="container">
          <router-view></router-view>
      </div>
    </section>
  </div>
</template>

<script>
import NavBar from './components/NavBar'
import { mapGetters, mapMutations } from 'vuex'
export default {
  name: 'app',
  components: {
    NavBar
  },
  computed: {
    ...mapGetters([
      'isAuthenticated',
      'rootPath'
    ])
  },
  methods: {
    ...mapMutations([
      'setToken',
      'setUser'
    ])
  },
  created () {
    const token = localStorage.getItem('token')
    if (token) {
      this.setToken(token)
    }
    const user = localStorage.getItem('user')
    if (user) {
      this.setUser(JSON.parse(user))
    }
  },
  mounted: function () {
    if (this.isAuthenticated) {
      this.$store.dispatch('fetchCatalogos')
      if (this.$route.name === 'login') {
        this.$router.push('/')
      }
    }
  },
  watch: {
    isAuthenticated: function (newState, oldState) {
      if (newState) {
        this.$store.dispatch('fetchCatalogos')
      } else {
        this.$router.push('/login')
      }
    }
  }
}
</script>
<style>
@-webkit-keyframes fadeIn {
    from { opacity: 0; }
      to { opacity: 1; }
}
@keyframes fadeIn {
    from { opacity: 0; }
      to { opacity: 1; }
}

#app {
}
.is-right{
  text-align: right;
}
.is-inline{
  display: inline-block;
}
.is-underlined{
  border-bottom:1px solid #ccc;
  padding-bottom: 10px;
  margin-bottom: 10px;
}

.in{
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}
</style>
