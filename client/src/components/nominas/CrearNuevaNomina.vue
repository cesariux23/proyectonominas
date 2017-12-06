<template lang="pug">
  .CrearNuevaNomina
    .columns
      .column
        router-link(:to="{ path: '/nominas'}" class="button is-info is-outlined is-medium" title="Volver al listado de nominas")
          b-icon(icon="arrow-left")
        h1.title.is-inline  Nuevo proceso de nómina
    form(@submit.prevent="validaNomina")
      .box
        .columns
          .column
            b-field(label="Tipo de nomina" v-if="catalogos.tipo_nomina")
            b-select(v-model="tipo_nomina" @input="cambiaTipoNomina")
              option(v-for="c in catalogos.tipo_nomina" :value="c") {{c.descripcion}}
         
          .column
            b-field(label="Tipo de emisión")
              b-select(v-model="nomina.tipo_emision" expanded)
                  <option value="ORDINARIO">ORDINARIO</option>
                  <option value="EXTRAORDINARIO">EXTRAORDINARIO</option>

          .column.notification(v-if="tipo_nomina.periodicidad")
            .columns
              .column
              b-field(label="Periodo") {{tipo_nomina.periodicidad}}
              .column
                <label class="label"> Año</label>
                <input type="text" class="input" v-model="nomina.anio" placeholder="AAAA">

              .column
                <label class="label"> Periodo inicial</label>
                <input type="text" class="input" v-model="nomina.periodo_inicio" placeholder="AAAAQQ" @change="cambiaPeriodoInicial">
             
              .column
                <label class="label"> Periodo final</label>
                <input type="text" class="input" v-model="nomina.periodo_fin" placeholder="AAAAQQ" :disabled="!habilita_periodo_fin">
             
           
         
       
        .columns
          .column
            label.label Descripción
            b-field
              b-input(
                placeholder="Descripción de la nomina a procesar"
                v-model="nomina.descripcion"
                expanded)
              p.control
                button.button.is-success(type="submit" :disabled="!guardar" :class="{'is-outlined': !guardar}")
                  b-icon(icon="check")
                  span Iniciar proceso de nomina
       
     
      <h4 class="title is-4">EMPLEADOS VINCULADOS</h4>
      .box
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Tipo de contrato</th>
              <th>Agregar a nomina</th>
              <th>Cargar conceptos fijos</th>
              <th>
                <span class="icon">
                  <i class="fa fa-cog"></i>
                </span>
              </th>
            </tr>
          </thead>
          <tr v-for="(empleado, index) in tipo_nomina.personal">
            <td>{{index+1}}</td>
            <td>{{empleado.nombre_completo}}</td>
            <td>{{empleado.tipo_contrato}}</td>
            <td>
              <input type="checkbox" :value="{datos_personales: empleado.id, empleado: empleado.puesto}" v-model="agregar_nomina">
            </td>
            <td>
              <input type="checkbox" :value="empleado.puesto" v-model="cargar_conceptos_fijos">
            </td>
            <td>
              <button type="button" class="button is-danger is-outlined" title="Eliminar vinculación">
                <span class="icon">
                  <i class="fa fa-times"></i>
                </span>
              </button>
            </td>
          </tr>
        </table>

     
    </form>
 
</template>

<script>
import { Quincena } from '../../utils/Quincena'
import Router from '../../router'
import { mapState } from 'vuex'
export default {
  name: 'CrearNuevaNomina',
  data () {
    return {
      guardar: false,
      nominas: [],
      catalogo: [],
      agregar_nomina: [],
      cargar_conceptos_fijos: [],
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
  watch: {
    nomina: function (val) {
      this.guardar = false
      if (val.tipo_nomina && val.anio && val.periodo_inicio && val.descripcion) {
        this.guardar = true
      }
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
        // marca todos los empleados vinculados
        this.agregarTodosEmpleados()
        this.cargaTodosConceptos()
      }
    },
    agregarTodosEmpleados: function () {
      this.agregar_nomina = []
      var self = this
      // recorre todos los empleados vinculados y los agrega
      this.tipo_nomina.personal.forEach((e, i) => {
        self.agregar_nomina.push({datos_personales: e.id, empleado: e.puesto})
      })
    },
    cargaTodosConceptos: function () {
      this.cargar_conceptos_fijos = []
      var self = this
      // recorre todos los empleados vinculados y los agrega
      this.tipo_nomina.personal.forEach((e, i) => {
        self.cargar_conceptos_fijos.push(e.id)
      })
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
    // guarda el proceso de nomina
    validaNomina: function () {
      var self = this
      if (this.nomina.tipo_nomina && this.nomina.periodo_inicio && this.nomina.descripcion) {
        // this.addNomina(this.nomina)
        this.modal = false
        this.$io.socket.post('/nomina', this.nomina, function (data) {
          if (data.error) {
            switch (data.error) {
              case 'E_VALIDATION':
                window.alert('Error de validación')
                break
              default:
                console.error(data)
            }
          } else {
            // se agregan los empleados a la nomina
            self.agregar_nomina.forEach((e) => {
              e.nomina = data.id
              // e.tipo_emision = data.tipo_emision
              if (self.cargar_conceptos_fijos.indexOf(e.datos_personales) >= 0) {
                e.cargar_conceptos_fijos = true
              }
              self.$io.socket.post('/empleadonomina', e, function (d) {
                console.log(d)
              })
            })
            Router.push('/nominas/' + data.id + '/edit')
          }
        })
      } else {
        window.alert('Faltan datos')
      }
    }
  },
  computed: {
    ...mapState(['catalogos'])
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
