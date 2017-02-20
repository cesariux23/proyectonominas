<template>
  <div class="ListaCatalogoNominas">
    <div class="box">
      <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>periodicidad</th>
          <th>Descripción</th>
          <th>Empleados vinculados</th>
          <th>ISR</th>
          <th>
            <span class="icon">
              <i class="fa fa-cog"></i>
            </span>
          </th>
        </tr>
      </thead>
      <tr v-for="(n, index) in catalogo">
        <td>{{index +1}}</td>
        <td>{{n.periodicidad}}</td>
        <td>{{n.descripcion}}</td>
        <td>{{n.personal.length}}</td>
        <td>{{n.isr}}</td>
        <td>
          <button type="button" class="button is-dark is-outlined">
            <span class="icon">
              <i class="fa fa-users"></i>
            </span>
          </button>
          <button type="button" class="button is-info is-outlined">
            <span class="icon">
              <i class="fa fa-edit"></i>
            </span>
          </button>
          <button type="button" class="button is-danger is-outlined">
            <span class="icon">
              <i class="fa fa-times"></i>
            </span>
          </button>
        </td>
      </tr>
    </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ListaCatalogoNominas',
  data () {
    return {
      catalogo: []
    }
  },
  methods: {
    getCatalogoNominas: function () {
      var self = this
      this.$io.socket.get('/catalogoNomina', {activa: true}, function (data) {
        self.catalogo = data
      })
    }
  },
  mounted: function () {
    this.getCatalogoNominas()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
