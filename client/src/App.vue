<template>
  <div id="app">
    <header>
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
// import { fetchPersonal, fetchNominas } from './vuex/actions'
import NavBar from './components/NavBar'

export default {
  name: 'app',
  components: {
    NavBar
  },
  // vuex: {
  //   actions: {
  //     fetchNominas,
  //     fetchPersonal
  //     // fetchCatalogoNominas
  //   }
  // },
  mounted: function () {
    // this.fetchPersonal()
    // this.fetchCatalogoNominas()
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
