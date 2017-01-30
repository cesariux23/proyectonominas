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
              {{nomina.id_catalogo_nomina}}
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
              {{nomina.id_catalogo_nomina}}
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
    {{nomina}}

    <!-- modal para crear la nueva nomina -->
    <div class="modal" :class="{'is-active' : modal}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Nuevo proceso de nomina</p>
      <button class="delete" v-on:click="modal=false"></button>
    </header>
    <section class="modal-card-body">
      <form>
        <div class="columns">
          <div class="column">
            <label class="label">Tipo de nomina</label>
            <p class="control">
              <span class="select" @change="cambiaTipoNomina">
                <select v-model="tipo_nomina">
                  <option v-for="c in catalogo" :value="c">{{c.descripcion}}</option>
                </select>
              </span>
            </p>
          </div>
          <div class="column">
            <label class="label">Tipo de emisión</label>
            <p class="control">
              <span class="select">
                <select v-model="nomina.tipo_nomina">
                  <option value="ORDINARIO">ORDINARIO</option>
                  <option value="EXTRAORDINARIO">EXTRAORDINARIO</option>
                </select>
              </span>
            </p>
          </div>
          <div class="column">
            <label class="label">Cargar conceptos fijos</label>
            <p class="control">
              <span class="select">
                <select>
                  <option value="true">SÍ</option>
                  <option value="false">NO</option>
                </select>
              </span>
            </p>
          </div>
        </div>
        <div class="notification" v-if="tipo_nomina.periodicidad">
          <h4 class="title is-4">PERIODO {{tipo_nomina.periodicidad}}</h4>
          <div class="columns">
            <div class="column">
              <label class="label"> Periodo inicial</label>
              <input type="text" class="input" v-model="nomina.periodo_inicial" placeholder="AAAAQQ" @change="cambiaPeriodoInicial">
            </div>
            <div class="column">
              <label class="label"> Periodo final</label>
              <input type="text" class="input" v-model="nomina.periodo_final" placeholder="AAAAQQ" :disabled="!habilita_periodo_final">
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <label class="label">Descripción</label>
            <p class="control">
              <input type="text" class="input" placeholder="Descripción de la nomina a procesar" v-model="nomina.descripcion">
            </p>
          </div>
        </div>
      </form>
    </section>
    <footer class="modal-card-foot">
      <a role="button" class="button is-primary" @click="iniciaNomina">
        <span class="icon"><i class="fa fa-check"></i></span>
        <span>Crear nomina</span>
      </a>
      <a role="button" class="button">Cancelar</a>
    </footer>
  </div>
</div>
  </div>
</template>

<script>
import { fetchNominas, fetchCatalogoNominas } from '../../vuex/actions'
import { getNominas, getCatalogoNominas } from '../../vuex/getters'
import { Quincena } from '../../utils/Quincena'
export default {
  name: 'ListaNominas',
  data () {
    return {
      // nominas: {},
      nomina: {
        tipo_nomina: 'ORDINARIO'
      },
      tipo_nomina: {},
      modal: false,
      habilita_periodo_final: false,
      quincenaActual: Quincena.quincenaActual()
    }
  },
  vuex: {
    getters: {
      nominas: getNominas,
      catalogo: getCatalogoNominas
    },
    actions: {
      fetchNominas,
      fetchCatalogoNominas
    }
  },
  methods: {
    inicializaNomina: function () {
      this.nomina = {
        tipo_nomina: 'ORDINARIO',
        periodo_inicial: this.quincenaActual.id,
        periodo_final: this.quincenaActual.id,
        descripcion: this.quincenaActual.descripcion
      }
    },
    cambiaTipoNomina: function () {
      if (this.tipo_nomina) {
        this.nomina.id_catalogo_nomina = this.tipo_nomina.id
        // calcula el periodo y la descripcion de la nomina
        this.calculaPeriodo()
      }
    },
    cambiaPeriodoInicial: function () {
      if (this.nomina.periodo_inicial) {
        this.quincenaActual = Quincena.calculaQuincena(this.nomina.periodo_inicial)
        this.calculaPeriodo()
      } else {
        this.$set(this.nomina, 'periodo_inicial', this.quincenaActual.id)
      }
    },
    calculaPeriodo: function () {
      let qi = parseInt(this.quincenaActual.id)
      let qf = qi
      let descripcion = this.quincenaActual.descripcion
      this.habilita_periodo_final = false
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
          this.habilita_periodo_final = true

      }
      this.$set(this.nomina, 'periodo_inicial', String(qi))
      this.$set(this.nomina, 'periodo_final', String(qf))
      this.$set(this.nomina, 'descripcion', descripcion)
    },
    // guarda la el proceso de nomina
    iniciaNomina: function () {
      window.alert('hola')
    }
  },
  mounted: function () {
    // this.fetchCatalogoNominas()
    // this.inicializaNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
