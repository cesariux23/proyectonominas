<template>
  <div class="CatalogoConceptos">
    <div class="columns">
      <div class="column">
        <h3 class="title">
          CATÁLOGO DE CONCEPTOS DE NÓMINA
        </h3>
      </div>
      <div class="column is-right">
        <button type="button" class="button is-primary">
          <span class="icon">
            <i class="fa fa-plus"></i>
          </span>
          <span>
            Agregar
          </span>
        </button>
      </div>
    </div>
    {{conceptos}}
    <div class="columns">
      <div class="column">
        <div class="box">
          <h4 class="title is-4">Percepciones</h4>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Clave</th>
                <th colspan="2">Descripción</th>
                <th colspan="2">Valor inicial</th>
                <th>
                  Exento
                </th>
                <th title="Fijable">
                  <span class="icon">
                    <i class="fa fa-thumb-tack"></i>
                  </span>
                </th>
                <th>
                  <span class="icon">
                    <i class="fa fa-cog"></i>
                  </span>
                </th>
              </tr>
            </thead>
            <tr v-for="(c, index) in conceptos">
              <th>{{index +1 }}</th>
              <td>{{c.clave}}</td>
              <td>{{c.descripcion_general}}</td>
              <td>
                <i class="fa fa-pencil"  v-if="c.descripcion_editable"></i>
              </td>
              <td>
                <span v-if="c.porcentaje">
                  {{c.porcentaje}}
                  %
                </span>
                <span-moneda v-if="c.monto_inicial" :valor="c.monto_inicial"></span-moneda>
              </td>
              <td>
                <i class="fa fa-pencil"  v-if="c.valor_editable"></i>
              </td>
              <td>
                <span class="icon" v-if="c.excento == 100">
                  <i class="fa fa-check"></i>
                </span>
              </td>
              <td>
                <span class="icon" v-if="c.fijable">
                  <i class="fa fa-check"></i>
                </span>
              </td>
              <td>
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
      <div class="column">
      </div>
    </div>
  </div>
</template>

<script>
import SpanMoneda from '../../components/utils/SpanMoneda'
export default {
  name: 'CatalogoConceptos',
  components: {
    'span-moneda': SpanMoneda
  },
  data () {
    return {
      conceptos: []
    }
  },
  methods: {
    getConceptos: function () {
      var self = this
      this.$io.socket.get('/catalogoconcepto', function (data) {
        self.conceptos = data
      })
    }
  },
  mounted: function () {
    this.getConceptos()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
td > i.fa{
  vertical-align: middle;
  font-size: 21px;
  color: #ddd;
}
</style>
