<template lang="pug">
  .CrearNuevaNomina
    form(@submit.prevent="validaNomina")
      .columns
        .column
          router-link(:to="{ name: 'listNomina'}" title="Volver al listado de nominas")
            b-icon(icon="arrow-circle-o-left" size="is-large" type="is-info")
          h2.title.is-2.font-weight-normal.is-inline Nuevo proceso de nómina
        .column.is-2
          b-field(grouped position="is-right")
            button.button.is-success(type="submit" :disabled="!guardar" :class="{'is-outlined': !guardar}")
              b-icon(icon="check")
              span Iniciar proceso de nomina

      .box
        .columns
          .column.is-6
            b-field(label="Tipo de nomina")
              b-select(v-model="nomina.tipo_nomina_id" placeholder="Seleccione" expanded)
                option(v-for="c in catalogos.tipo_nomina" :value="c.id") {{c.descripcion}}
          .column
            b-field(label="Periodicidad")
              b-select(v-model="nomina.periodicidad" expanded)
                option(v-for="p in catalogos.periodicidad" :value="p") {{p}}

          .column
            b-field(label="Tipo de emisión")
              b-select(v-model="nomina.tipo_emision" expanded)
                option(v-for="e in catalogos.emision" :value="e") {{e}}
        .columns.notification(v-if="nomina.periodicidad")
          .column.is-2
            b-field(label="Ejercicio")
              b-input( type="number" v-model="nomina.ejercicio" min="2016")
          .column(v-if="nomina.periodicidad !== 'OTRO'")
            b-field(label="Mes")
              b-select(v-model="mes" expanded)
                option(v-for="(m, i) in meses" :value="i") {{m.toUpperCase()}}
          .column(v-if="nomina.periodicidad === 'QUINCENAL'")
            b-field(label="Quincena")
              b-select(v-model="nomina.ordinal" expanded)
                option(value="1") PRIMERA
                option(value="2") SEGUNDA
          .column
            b-field(label="Del")
              b-input(type="date" v-model="nomina.fecha_inicio")
          .column
            b-field(label="Al")
              b-input(type="date" v-model="nomina.fecha_fin")
        .columns
          .column
            label.label Descripción
            b-field
              b-input(
                placeholder="Descripción de la nomina a procesar"
                v-model="nomina.descripcion"
                expanded)
      b-tabs(type="is-boxed")
        b-tab-item(label="Configuración")
          configurar-nomina(:config.sync="nomina.configuracion" :conceptos.sync="nomina.conceptos" :tipo="tipoNomina" use-default)
        b-tab-item(label="Personas")
</template>
<script>
import moment from 'moment'
import { Quincena } from '../../utils/Quincena'
import ConfigurarNomina from './partials/Configuracion'
import { mapState, mapActions } from 'vuex'
export default {
  name: 'NuevaNomina',
  components: {
    ConfigurarNomina
  },
  data () {
    return {
      guardar: false,
      mes: '',
      nomina: {
        periodicidad: 'QUINCENAL',
        status: 'EN PROCESO',
        tipo_emision: 'ORDINARIA',
        ejercicio: 2017,
        descripcion: '',
        ordinal: 1,
        configuracion: {},
        conceptos: {}
      },
      tipo_nomina: {
        tipo_empleado: ''
      },
      quincenaActual: Quincena.quincenaActual()
    }
  },
  watch: {
    'nomina.tipo_nomina_id' (value) {
      this.nominaFilter = {}
      if (this.tipoNomina.tipo_empleado) {
        this.nominaFilter = {
          tipo_contrato: this.tipoNomina.tipo_empleado,
          status_text: this.nomina.periodicidad !== 'OTRO' ? 'ACTIVO' : null
        }
      }
      this.nomina.configuracion = {}
      this.nomina.conceptos = {}
    },
    'nomina.periodicidad': {
      handler (value) {
        this.calculaPeriodo()
        this.nominaFilter.status_text = value !== 'OTRO' ? 'ACTIVO' : null
      },
      deep: true
    },
    'nomina.ejercicio': {
      handler (value) {
        this.calculaPeriodo()
      },
      deep: true
    },
    'mes': {
      handler (value) {
        this.calculaPeriodo()
      }
    },
    'nomina.ordinal': {
      handler (value) {
        this.calculaPeriodo()
      }
    },
    'nomina': {
      handler (value) {
        this.guardar = false
        if (value.tipo_nomina_id && value.ejercicio && value.descripcion) {
          this.guardar = true
        }
      },
      deep: true
    }
  },
  methods: {
    inicializaNomina: function () {
      this.nomina.descripcion = this.quincenaActual.descripcion
      this.nomina.fecha_inicio = this.quincenaActual.inicio.format('YYYY-MM-DD')
      this.nomina.fecha_fin = this.quincenaActual.fin.format('YYYY-MM-DD')
      this.nomina.ejercicio = this.quincenaActual.anio
      this.mes = this.quincenaActual._mes - 1
      this.nomina.quincena = this.quincenaActual._quincena
    },
    calculaPeriodo: function () {
      const anio = this.nomina.ejercicio
      const mes = this.mes + 1
      const ordinal = this.nomina.ordinal
      this.nomina.periodo = null
      switch (this.nomina.periodicidad) {
        case 'QUINCENAL':
          // se modifica la quincena actual de acuerdo a los valores proporcionados
          const q = mes * 2 - (ordinal === '2' ? 0 : 1)
          const id = String(anio) + String(q > 10 ? q : '0' + String(q))
          this.quincenaActual = Quincena.calculaQuincena(id)
          // se cambia los valores de acuerdo al calculo
          this.nomina.descripcion = this.quincenaActual.descripcion
          this.nomina.fecha_inicio = this.quincenaActual.inicio.format('YYYY-MM-DD')
          this.nomina.fecha_fin = this.quincenaActual.fin.format('YYYY-MM-DD')
          this.nomina.periodo = 'Q' + this.quincenaActual.id
          break
        case 'MENSUAL':
          const fecha = moment()
          fecha.year(anio)
          fecha.month(mes - 1)
          fecha.date(1)
          this.nomina.descripcion = this.meses[mes - 1].toUpperCase() + ' DE ' + String(anio)
          this.nomina.periodo = 'M' + anio + mes.toString().padStart(2, '0')
          this.nomina.fecha_inicio = fecha.format('YYYY-MM-DD')
          fecha.add(1, 'months')
          fecha.subtract(1, 'days')
          this.nomina.fecha_fin = fecha.format('YYYY-MM-DD')
          break
        default:
          this.nomina.descripcion = null
          this.nomina.periodo = null
          break
      }
    },
    // guarda el proceso de nomina
    validaNomina: function () {
      if (this.nomina.tipo_nomina_id && this.nomina.ejercicio && this.nomina.descripcion) {
        this.$dialog.confirm({
          title: 'Iniciar proceso de nómina',
          message: `<p>Tipo nómina:</p>
          <p><b>${this.tipoNomina.descripcion}</b></p>
          <p>Periodicidad:</p>
          <p><b>${this.nomina.periodicidad}</b></p>
          <p>descripción:</p>
          <p><b>${this.nomina.descripcion}</b></p>`,
          confirmText: 'Iniciar',
          cancelText: 'Cancelar',
          type: 'is-info',
          hasIcon: true,
          onConfirm: () => {
            this.saveNomina(this.nomina).then((respose) => {
              this.$toast.open({
                duration: 5000,
                message: 'Nomina creada correctamente.',
                position: 'is-bottom-right',
                type: 'is-success'
              })
              this.$router.push({ name: 'desgloseNomina', params: { id: respose.id } })
            }, (error) => {
              this.$toast.open({
                duration: 5000,
                message: error.data.error,
                position: 'is-top-right',
                type: 'is-danger'
              })
            })
          }
        })
      }
    },
    ...mapActions({
      saveNomina: 'nominas/saveNomina'
    })
  },
  computed: {
    tipoNomina () {
      return this.nomina.tipo_nomina_id
        ? this.catalogos.tipo_nomina.find((n) => n.id === this.nomina.tipo_nomina_id) : {}
    },
    ...mapState(['catalogos', 'meses'])
  },
  mounted: function () {
    this.inicializaNomina()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
