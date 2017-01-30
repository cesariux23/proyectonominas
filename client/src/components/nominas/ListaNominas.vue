<template>
  <div class="ListaNominas">
    <div class="columns">
      <div class="column is-1">
        <a role="button" class="button is-primary" v-on:click="modal=true">
          <span class="icon"><i class="fa fa-plus"></i></span>
          <span>Nuevo proceso de nomina</span>
        </a>
      </div>
    </div>
    <h3 class="title">NOMINAS EN PROCESO</h3>
    <div class="box">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Periodo</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(nomina, index) in nominas" v-if="nomina.estado=='EN_PROCESO'">
            <td>{{index+1}}</td>
            <td>{{nomina.periodo}}</td>
            <td>{{nomina.descripcion}}</td>
            <td>
              {{nomina.cat_nomina.descripcion}}
              <br>
              {{nomina.tipo_nomina}}
            </td>
            <td>{{nomina.estado}}</td>
            <td>
              <router-link v-if="nomina.estado=='EN_PROCESO'" :to="{ path: 'nominas/'+nomina.id+'/edit'}" class="button is-primary is-outlined" title="Continuar">
                <span class="icon">
                  <i class="fa fa-pencil"></i>
                </span>
                <span>Continuar</span>
              </router-link>
              <a v-if="nomina.estado=='PENDIENTE_PAGO'" href="#" class="button"> Marcar como pagada</a>
              <a v-if="nomina.estado!='PROCESO'" href="#" class="button"> Reportes</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <h3 class="title">HISTORIAL DE NOMINAS</h3>
    <div class="box">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Periodo</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(nomina, index) in nominas"  v-if="nomina.estado!='EN_PROCESO'">
            <td>{{index+1}}</td>
            <td>{{nomina.periodo}}</td>
            <td>{{nomina.descripcion}}</td>
            <td>
              {{nomina.cat_nomina.descripcion}}
              <br>
              {{nomina.tipo_nomina}}
            </td>
            <td>{{nomina.estado}}</td>
            <td>
              <a v-if="nomina.estado=='EN_PROCESO'" href="#" class="button"> Continuar</a>
              <a v-if="nomina.estado=='PENDIENTE_PAGO'" href="#" class="button"> Marcar como pagada</a>
              <a v-if="nomina.estado!='PROCESO'" href="#" class="button"> Reportes</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- modal para crear la nueva nomina -->
    <div class="modal" v-bind:class="{'is-active' : modal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Nuevo proceso de nomina</p>
      <button class="delete" v-on:click="modal=false"></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
    </section>
    <footer class="modal-card-foot">
      <a class="button is-primary">
        <span class="icon"><i class="fa fa-check"></i></span>
        <span>Crear nomina</span>
      </a>
      <a class="button">Cancelar</a>
    </footer>
  </div>
</div>
  </div>
</template>

<script>
export default {
  name: 'ListaNominas',
  data () {
    return {
      nominas: {},
      modal: false
    }
  },
  methods: {
    getNominas: function () {
      var self = this
      this.$http.get('nominas', {})
    .then(function (response) {
      self.nominas = response.data
    })
    .catch(function (error) {
      console.log(error)
    })
    }
  },
  mounted: function () {
    this.getNominas()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
