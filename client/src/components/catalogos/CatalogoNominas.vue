<template>
  <div class="CatalogoNominas">
    <div class="columns">
      <div class="column">
        <h3 class="title is-3">
          CATÁLOGO DE NOMINAS
        </h3>
      </div>
      <div class="column is-right">
        <button type="button" class="button is-primary">
          <span class="icon">
            <i class="fa fa-plus"></i>
          </span>
          <span>Agregar</span>
        </button>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'CatalogoNominas',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
