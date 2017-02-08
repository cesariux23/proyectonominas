<template>
  <div class="CrearNuevaNomina">
    <h1 class="title">Nuevo proceso de Nomina</h1>
    <hr>
    <form @submit.prevent="validaNomina">
      <div class="box">
        <div class="columns">
          <div class="column is-3">
            <label class="label">Tipo de nomina</label>
            <p class="control">
              <span class="select" @change="cambiaTipoNomina">
                <select v-model="tipo_nomina">
                  <option v-for="c in catalogo" :value="c">{{c.descripcion}}</option>
                </select>
              </span>
            </p>
          </div>
          <div class="column is-2">
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

          <div class="column notification" v-if="tipo_nomina.periodicidad">
            <div class="columns">
              <div class="column">
                <h4 class="title is-4">
                  PERIODO
                  <br>
                  {{tipo_nomina.periodicidad}}
                </h4>
              </div>
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
        </div>
        <div class="columns">
          <div class="column">
            <label class="label">Descripción</label>
            <p class="control">
              <input type="text" class="input" placeholder="Descripción de la nomina a procesar" v-model="nomina.descripcion">
            </p>
          </div>
          <div class="column is-2">
            <br>
            <button type="submit" class="button is-success is-large is-outlined">
              <span class="icon">
                <i class="fa fa-check"></i>
              </span>
              <span>Generar nomina</span>
            </button>
          </div>
        </div>
      </div>
      <div class="box">
        <h4 class="is-4">EMPLEADOS VINCULADOS</h4>
        {{tipo_nomina}}
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Agregar a nomina</th>
              <th>Cargar conceptos fijos</th>
            </tr>
          </thead>

        </table>

      </div>
    </form>
  </div>
</template>

<script>
import { Quincena } from '../../utils/Quincena'
export default {
  name: 'CrearNuevaNomina',
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
    getCatalogoNominas: function () {
      var self = this
      this.$io.socket.get('/catalogoNomina', {activa: true}, function (data) {
        console.log(data)
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
    },
    // guarda la el proceso de nomina
    validaNomina: function () {
      if (this.nomina.tipo_nomina && this.nomina.periodo_inicio && this.nomina.descripcion) {
        // this.addNomina(this.nomina)
        this.modal = false
        // , (result) => {
        //   Router.push('/nominas/' + result.id + '/edit')
        // })
        this.$io.socket.post('/nomina', this.nomina, function (data) {
          console.log(data)
        })
      } else {
        window.alert('Faltan datos')
      }
    }
  },
  mounted: function () {
    this.getCatalogoNominas()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
</style>
