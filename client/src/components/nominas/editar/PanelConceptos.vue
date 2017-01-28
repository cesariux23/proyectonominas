x<template>
  <div class="PanelConceptos">
    <div class="card">
      <header class="card-header">
       <p class="card-header-title">
         {{titulo}}
       </p>
       <a class="card-header-icon">
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
              <th>descripción</th>
              <th>%</th>
              <th>Monto</th>
              <th>Record</th>
              <th>
                <span class="icon">
                   <i class="fa fa-cog"></i>
                </span>
                Opciones
              </th>
            </tr>
          </thead>

            <tr>
              <td>1</td>
              <td>SUELDO BASE TABULAR</td>
              <td>--</td>
              <td>
                <p class="control has-icon">
                  <input class="input" type="text" placeholder="monto">
                  <span class="icon is-small">
                    <i class="fa fa-usd"></i>
                  </span>
                </p>
              </td>
              <td>
                --
              </td>
              <td>
                <button type="button" class="button is-dark is-outlined" title="Programar repetición">
                  <span class="icon"><i class="fa fa-calendar-check-o"></i></span>
                </button>
                <button type="button" class="button is-danger is-outlined">
                  <span class="icon"><i class="fa fa-times"></i></span>
                </button>
              </td>
            </tr>

        </table>
      </div>
    </div>
    <footer class="card-footer">
      <div class="card-footer-item">
        SUMA TOTAL  DE {{titulo}}
      </div>
      <div class="card-footer-item">
        <h3 class="title is-4"><b>$ ####.00</b></h3>
      </div>

    </footer>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PanelConceptos',
  props: ['titulo'],
  vuex: {
    getters: {
      quincena: state => state.quincena
    }
  },
  data () {
    return {
      msg: 'Desgloce quincenal del empleado'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
