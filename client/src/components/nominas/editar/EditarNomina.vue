<template>
  <div class="EditarNomina">
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
      // nomina: this.getNomina(this.id)
    }
  },
  // vuex: {
  //   getters: {
  //     getNomina
  //   }
  // },
  methods: {
    // getNomina: function () {
    //   var self = this
    //   this.$http.get('nominas/' + self.id, {})
    // .then(function (response) {
    //   self.nomina = response.data
    // })
    // .catch(function (error) {
    //   console.log(error)
    // })
    // }
  },
  mounted: function () {

  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
