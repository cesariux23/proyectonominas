x<template>
  <div class="PanelConceptos">
    <div class="card">
      <header class="card-header">
       <p class="card-header-title">
         {{titulo}}
       </p>
       <a class="card-header-icon" role="button" @click="mostrarModal()">
         <span class="icon">
           <i class="fa fa-plus"></i>
         </span>
       </a>
     </header>
     <div class="card-content">
      <div class="content">
        <table class="table is-bordered">
          <thead>
            <tr>
              <th>Núm.</th>
              <th>Clave</th>
              <th>Descripción</th>
              <th>%</th>
              <th>Monto</th>
              <th>
                <span class="icon">
                   <i class="fa fa-cog"></i>
                </span>
              </th>
            </tr>
          </thead>
            <tr v-for="(c, index) in conceptos">
              <td>{{index + 1 }}</td>
              <td>{{c.clave}}</td>
              <td>
                <p class="control" v-if="c.descripcion_editable">
                  <input type="text" class="input" v-model="c.descripcion"  @change="enviarCambios(c)">
                </p>
                <span v-else>
                  {{c.descripcion}}
                </span>
              </td>
              <td>--</td>
              <td>

                <p class="control has-icon" v-if="c.valor_editable">
                  <input class="input" type="text" placeholder="monto" v-model="c.monto" @change="enviarCambios(c)" @focus="almacenaPrevio(c)" @keypress="cargarPrevio(c)">
                  <span class="icon is-small">
                    <i class="fa fa-usd"></i>
                  </span>
                </p>
                <span v-else>
                  {{c.monto}}
                </span>
              </td>
              <td>
                <button type="button" class="button is-danger is-outlined" title="Eliminar concepto" @click="eliminar(c.id)">
                  <span class="icon"><i class="fa fa-times"></i></span>
                </button>
              </td>
            </tr>
        </table>
      </div>
      <div class="columns">
        <div class="column">
          TOTAL {{titulo}}
        </div>
        <div class="column">
          <h3 class="title is-5"><b>$ {{total}}</b></h3>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PanelConceptos',
  props: ['titulo', 'conceptos', 'tipo'],
  data () {
    return {
      t: 0,
      previo: {}
    }
  },
  computed: {
    total: function () {
      var t = 0
      this.conceptos.forEach((c) => {
        if (c.monto) {
          t += Number.parseFloat(c.monto)
        }
      })
      this.$emit('cambiaTotal', this.tipo, t)
      return t.toFixed(2)
    }
  },
  methods: {
    mostrarModal: function () {
      this.$emit('mostrarModal', this.tipo)
    },
    almacenaPrevio: function (c) {
      this.previo = c
    },
    enviarCambios: function (conceptoModificado) {
      this.$emit('actualizaConcepto', conceptoModificado)
    },
    cargarPrevio: function (event, actual, previo) {
      console.log(event)
    },
    eliminar: function (id) {
      this.$emit('eliminarConcepto', id)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
