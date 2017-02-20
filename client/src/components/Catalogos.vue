<template>
  <div class="Catalogos">
    <div class="tabs is-boxed">
      <ul>
        <router-link to="/catalogos/adscripciones" active-class="is-active" tag="li"><a>Adscripciones</a></router-link>
        <router-link to="/catalogos/conceptos" active-class="is-active" tag="li"><a>Conceptos</a></router-link>
        <router-link to="/catalogos/nominas" active-class="is-active" tag="li"><a> Nominas</a></router-link>
      </ul>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'Catalogos',
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
</style>
