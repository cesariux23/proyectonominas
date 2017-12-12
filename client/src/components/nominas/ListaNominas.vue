<template>
  <div class="ListaNominas">
    <div class="columns">
      <div class="column">
        <h1 class="title">Nóminas</h1>
      </div>
      <div class="column is-right">
        <router-link to="/nominas/new" class="button is-primary">
          <span class="icon"><i class="fa fa-plus"></i></span>
          <span>Nuevo proceso de nómina</span>
        </router-link>
      </div>
    </div>

    <div class="box">
      <h3 class="title">Procesos activos</h3>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Ejercicio</th>
            <th>Periódo</th>
            <th>Descripción</th>
            <th>Emisión</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody v-if="nominas.length">
          <tr v-for="(nomina, index) in nominas" v-if="nomina.status=='EN_PROCESO'" :key="nomina.id">
            <td>{{index+1}}</td>
            <td>{{nomina.ejercicio}}</td>
            <td>
              {{nomina.periodo}}
              <br>
              {{nomina.periodicidad}}
            </td>
            <td>
              {{nomina.descripcion}}
              <br>
              <span v-if="nomina.tipo_nomina">
                {{nomina.tipo_nomina.descripcion}}
              </span>
            </td>
            <td>{{nomina.tipo_emision}}</td>
            <td>{{nomina.status}}</td>
            <td>
              <router-link v-if="nomina.status=='EN_PROCESO'" :to="{ path: 'nominas/'+nomina.id+'/edit'}" class="button is-info is-outlined" title="Continuar">
                <span class="icon">
                  <i class="fa fa-pencil"></i>
                </span>
              </router-link>
              <a v-if="nomina.status=='PENDIENTE_PAGO'" href="#" class="button"> Marcar como pagada</a>
              <a v-if="nomina.status!='PROCESO'" href="#" class="button"> Reportes</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="box">
      <h3 class="title">Historial</h3>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Periodicidad</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(nomina, index) in nominas"  v-if="nomina.status!='EN_PROCESO'" :key="nomina.id">
            <td>{{index+1}}</td>
            <td>
              {{nomina.periodo}}
              <br>
              {{nomina.periodicidad}
            </td>
            <td>{{nomina.descripcion}}</td>
            <td>
              {{nomina.tipo_nomina.descripcion}}
              <br>
              {{nomina.tipo_emision}}
            </td>
            <td>{{nomina.status}}</td>
            <td>
              <a v-if="nomina.status=='EN_PROCESO'" href="#" class="button"> Continuar</a>
              <a v-if="nomina.status=='PENDIENTE_PAGO'" href="#" class="button"> Marcar como pagada</a>
              <a v-if="nomina.status!='PROCESO'" href="#" class="button"> Reportes</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- modal para crear la nueva nomina -->
    <div class="modal" :class="{'is-active' : modal}">
      <div class="modal-background"></div>

        <footer class="modal-card-foot">
          <button type="submit" class="button is-primary">
            <span class="icon"><i class="fa fa-check"></i></span>
            <span>Crear nomina</span>
          </button>
          <a role="button" class="button">Cancelar</a>
        </footer>
      </div>
    </form>
    </div>
  </div>
</template>

<script>
import { Quincena } from '../../utils/Quincena'
import { mapActions } from 'vuex'
export default {
  name: 'ListaNominas',
  data () {
    return {
      nominas: [],
      catalogo: [],
      nomina: {
        estado: 'EN_PROCESO',
        tipo_emision: 'ORDINARIO',
        anio: 2017
      },
      tipo_nomina: {},
      modal: false,
      habilita_periodo_fin: false,
      cargar_fijos: true,
      quincenaActual: Quincena.quincenaActual()
    }
  },
  methods: {
    ...mapActions(['fetchNominas'])
  },
  mounted: function () {
    this.fetchNominas().then(response => {
      this.nominas = response
    })
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
