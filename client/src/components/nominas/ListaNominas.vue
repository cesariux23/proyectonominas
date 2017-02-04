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
          <tr v-for="(nomina, index) in nominas" v-if="nomina.status=='EN_PROCESO'">
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
              <router-link v-if="nomina.status=='EN_PROCESO'" :to="{ path: 'nominas/'+nomina.id+'/edit'}" class="button is-primary is-outlined" title="Continuar">
                <span class="icon">
                  <i class="fa fa-pencil"></i>
                </span>
                <span>Continuar</span>
              </router-link>
              <a v-if="nomina.status=='PENDIENTE_PAGO'" href="#" class="button"> Marcar como pagada</a>
              <a v-if="nomina.status!='PROCESO'" href="#" class="button"> Reportes</a>
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
      <form @submit.prevent="validaNomina">
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Nuevo proceso de nomina</p>
            <button class="delete" v-on:click="modal=false"></button>
          </header>
          <section class="modal-card-body">
            <label class="label">Tipo de nomina</label>
            <p class="control">
              <span class="select" @change="cambiaTipoNomina">
                <select v-model="tipo_nomina">
                  <option v-for="c in catalogo" :value="c">{{c.descripcion}}</option>
                </select>
              </span>
            </p>
            <div class="columns">
              <div class="column">
                <label class="label">Tipo de emisión</label>
                <p class="control">
                  <span class="select">
                    <select v-model="nomina.tipo_emision">
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
                    <select v-model="cargar_fijos">
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
                  <label class="label"> Año</label>
                  <input type="text" class="input" v-model="nomina.anio" placeholder="AAAA">
                </div>
                <div class="column">
                  <label class="label"> Periodo inicial</label>
                  <input type="text" class="input" v-model="nomina.periodo_inicio" placeholder="AAAAQQ" @change="cambiaPeriodoInicial">
                </div>
                <div class="column">
                  <label class="label"> Periodo final</label>
                  <input type="text" class="input" v-model="nomina.periodo_fin" placeholder="AAAAQQ" :disabled="!habilita_periodo_fin">
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
              <div class="column">
              </div>
            </div>
        </section>
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
import { fetchNominas, fetchCatalogoNominas, addNomina } from '../../vuex/actions'
import { getNominas, getCatalogoNominas } from '../../vuex/getters'
import { Quincena } from '../../utils/Quincena'
// import Router from '../../router'
export default {
  name: 'ListaNominas',
  data () {
    return {
      // nominas: {},
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
  vuex: {
    getters: {
      nominas: getNominas,
      catalogo: getCatalogoNominas
    },
    actions: {
      fetchNominas,
      fetchCatalogoNominas,
      addNomina
    }
  },
  methods: {
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
    },
    // guarda la el proceso de nomina
    validaNomina: function () {
      if (this.nomina.tipo_nomina && this.nomina.periodo_inicio && this.nomina.descripcion) {
        this.addNomina(this.nomina)
        this.modal = false
        // , (result) => {
        //   Router.push('/nominas/' + result.id + '/edit')
        // })
      } else {
        window.alert('Faltan datos')
      }
    }
  },
  mounted: function () {
    this.fetchNominas()
    this.fetchCatalogoNominas()
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
