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
            <th>Año</th>
            <th>Periodo</th>
            <th>Descripción</th>
            <th>Emisión</th>
            <th>Tipo</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody v-if="nominas.length">
          <tr v-for="(nomina, index) in nominas" v-if="nomina.status=='EN_PROCESO'">
            <td>{{index+1}}</td>
            <td>{{nomina.anio}}</td>
            <td>
              {{nomina.periodo_inicio}}
            </td>
            <td>{{nomina.descripcion}}</td>
            <td>{{nomina.tipo_emision}}</td>
            <td>
              <span v-if="nomina.tipo_nomina">
                {{nomina.tipo_nomina.descripcion}}
              </span>
            </td>
            <td>{{nomina.status}}</td>
            <td>
              <router-link v-if="nomina.status=='EN_PROCESO'" :to="{ path: 'nominas/'+nomina.id+'/edit'}" class="button is-info is-outlined" title="Continuar">
                <span class="icon">
                  <i class="fa fa-pencil"></i>
                </span>
                <span>Continuar editando</span>
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
            <th>Periodo</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Status</th>
            <th title="Acciones"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(nomina, index) in nominas"  v-if="nomina.status!='EN_PROCESO'">
            <td>{{index+1}}</td>
            <td>
              {{nomina.periodo_inicio}}
              <br>
              {{nomina.periodo_fin}}
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
// import { fetchNominas, fetchCatalogoNominas, addNomina } from '../../vuex/actions'
// import { getNominas, getCatalogoNominas } from '../../vuex/getters'
import { Quincena } from '../../utils/Quincena'
// import Router from '../../router'
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
    getNominas: function () {
      var self = this
      this.$io.socket.get('/nomina', function (data) {
        self.nominas = data
      })
      // escucha los cambios de la coleccion
      this.$io.socket.on('nomina', function (data) {
        console.log(data)
      })
    },
    getCatalogoNominas: function () {
      var self = this
      this.$io.socket.get('/catalogoNomina', function (data) {
        self.catalogo = data
      })
    },
    inicializaNomina: function () {
      this.nomina = {
        tipo_emision: 'ORDINARIO',
        periodo_inicio: this.quincenaActual.id,
        periodo_fin: this.quincenaActual.id,
        descripcion: this.quincenaActual.descripcion,
        anio: 2017
      }
    },
    cambiaTipoNomina: function () {
      if (this.tipo_nomina) {
        this.nomina.tipo_nomina = this.tipo_nomina.id
        // calcula el periodo y la descripcion de la nomina
        this.calculaPeriodo()
      }
    },
    cambiaPeriodoInicial: function () {
      if (this.nomina.periodo_inicio) {
        this.quincenaActual = Quincena.calculaQuincena(this.nomina.periodo_inicio)
        this.calculaPeriodo()
      } else {
        this.$set(this.nomina, 'periodo_inicio', this.quincenaActual.id)
      }
    },
    calculaPeriodo: function () {
      let qi = parseInt(this.quincenaActual.id)
      let qf = qi
      let descripcion = this.quincenaActual.descripcion
      this.habilita_periodo_fin = false
      switch (this.tipo_nomina.periodicidad) {
        case 'QUINCENAL':
          // deshabilita el periodo final
          break
        case 'MENSUAL':
          if (qi % 2 === 0) {
            // se le resta una para que corresponda a la primer quincena
            qi -= 1
          }
          qf = qi + 1
          descripcion = this.quincenaActual.mes + ' DE ' + this.quincenaActual.anio
          break
        default:
          qf = this.quincenaActual.anio
          descripcion = this.quincenaActual.anio
          this.habilita_periodo_fin = true

      }
      this.$set(this.nomina, 'periodo_inicio', String(qi))
      this.$set(this.nomina, 'periodo_fin', String(qf))
      this.$set(this.nomina, 'descripcion', descripcion)
    }
  },
  mounted: function () {
    this.getNominas()
    this.getCatalogoNominas()
    this.inicializaNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
