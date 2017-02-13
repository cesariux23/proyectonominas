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
              <td>{{c.descripcion}}</td>
              <td>--</td>
              <td>
                <p class="control has-icon">
                  <input class="input" type="text" placeholder="monto" v-model="c.monto">
                  <span class="icon is-small">
                    <i class="fa fa-usd"></i>
                  </span>
                </p>
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
      msg: 'Desgloce quincenal del empleado'
    }
  },
  computed: {
    total: function () {
      var t = 0
      this.conceptos.forEach((c) => {
        t += c.monto
      })
      return t
    }
  },
  methods: {
    mostrarModal: function () {
      this.$emit('mostrarModal', this.tipo)
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
