<template lang="pug">
  .CrearNuevaNomina
    .columns
      .column
        router-link.button.is-info.is-outlined(:to="{ path: '/nominas'}" title="Volver al listado de nominas")
          b-icon(icon="arrow-left")
        h1.title.is-inline  Nuevo proceso de nómina
    form(@submit.prevent="validaNomina")
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
                option(value="ORDINARIO") ORDINARIO
                option(value="EXTRAORDINARIO") EXTRAORDINARIO
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
              b-select(v-model="quincena" expanded)
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
              p.control
                button.button.is-success(type="submit" :disabled="!guardar" :class="{'is-outlined': !guardar}")
                  b-icon(icon="check")
                  span Iniciar proceso de nomina
      | {{nomina}}
</template>
<script>
import moment from 'moment'
import { Quincena } from '../../utils/Quincena'
import { mapState, mapActions } from 'vuex'
export default {
  name: 'CrearNuevaNomina',
  data () {
    return {
      guardar: false,
      mes: '',
      quincena: 0,
      nomina: {
        periodicidad: 'QUINCENAL',
        estado: 'EN_PROCESO',
        tipo_emision: 'ORDINARIO',
        ejercicio: 2017,
        descripcion: ''
      },
      tipo_nomina: {},
      quincenaActual: Quincena.quincenaActual()
    }
  },
  watch: {
    'nomina.periodicidad': {
      handler (value) {
        this.calculaPeriodo()
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
    'quincena': {
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
      this.quincena = this.quincenaActual._quincena
    },
    calculaPeriodo: function () {
      const anio = this.nomina.ejercicio
      const mes = this.mes + 1
      const quincena = this.quincena
      this.nomina.periodo = null
      switch (this.nomina.periodicidad) {
        case 'QUINCENAL':
          // se modifica la quincena actual de acuerdo a los valores proporcionados
          const q = mes * 2 - (quincena === '2' ? 0 : 1)
          const id = String(anio) + String(q > 10 ? q : '0' + String(q))
          this.quincenaActual = Quincena.calculaQuincena(id)
          // se cambia los valores de acuerdo al calculo
          this.nomina.descripcion = this.quincenaActual.descripcion
          this.nomina.fecha_inicio = this.quincenaActual.inicio.format('YYYY-MM-DD')
          this.nomina.fecha_fin = this.quincenaActual.fin.format('YYYY-MM-DD')
          this.nomina.periodo = this.quincenaActual.id
          break
        case 'MENSUAL':
          const fecha = moment()
          fecha.year(anio)
          fecha.month(mes - 1)
          fecha.date(1)
          this.nomina.descripcion = this.meses[mes - 1].toUpperCase() + ' DE ' + String(anio)
          this.nomina.periodo = this.nomina.descripcion
          this.nomina.fecha_inicio = fecha.format('YYYY-MM-DD')
          fecha.add(1, 'months')
          fecha.subtract(1, 'days')
          this.nomina.fecha_fin = fecha.format('YYYY-MM-DD')
          break
        case 'OTRO':
          this.nomina.descripcion = null
          break
      }
    },
    // guarda el proceso de nomina
    validaNomina: function () {
      if (this.nomina.tipo_nomina_id && this.nomina.ejercicio && this.nomina.descripcion) {
        this.$dialog.confirm({
          title: 'Confirmar acción',
          message: `¿Deseas iniciar el siguente proceso de nómina? <br>
          <p>Tipo nómina:</p>
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
                position: 'is-top-right',
                type: 'is-success'
              })
              this.$router.push('/nominas/' + respose.id + '/edit')
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
    ...mapActions(['saveNomina'])
  },
  computed: {
    tipoNomina () {
      return this.catalogos.tipo_nomina.find(n => n.id === this.nomina.tipo_nomina_id)
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
h1, h2 {
  font-weight: normal;
}
</style>
