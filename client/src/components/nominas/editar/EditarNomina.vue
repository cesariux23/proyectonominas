<template>
  <div class="EditarNomina">
    <div class="columns">
      <div class="column">
        <h1 class="title">{{nomina.descripcion}}</h1>
        <h2 class="subtitle">{{nomina.id_catalogo_nomina}}</h2>
      </div>
      <div class="column is-one-quarter">
        <p class="block">
          <router-link v-if="nomina.estado=='EN_PROCESO'" :to="{ path: '/nominas/'+nomina.id+'/edit'}" class="button is-info is-outlined">
            <span class="icon">
              <i class="fa fa-list"></i>
            </span>
            <span>Ir al listado</span>
          </router-link>
          <a class="button is-primary" role="button">
            <span class="icon"><i class="fa fa-user-plus"></i></span>
               <span>Agregar empleados</span>
          </a>
        </p>
      </div>
    </div>
    <hr>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'EditarNomina',
  data () {
    return {
      nomina: {
        cat_nomina: {
        },
        empleados: []
      }
    }
  },
  methods: {
    getNomina: function () {
      var self = this
      this.$http.get('nominas/' + self.id, {})
    .then(function (response) {
      self.nomina = response.data
    })
    .catch(function (error) {
      console.log(error)
    })
    }
  },
  mounted: function () {
    this.id = this.$route.params.id
    this.getNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
