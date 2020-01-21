<template lang="pug">
  #Configuracion
    h4.title.is-4 General
    .columns.box.is-multiline
      .column.is-4(v-for="(conf, key) in configuracion")
        b-switch(
          v-model="config[conf.key]"
          true-value=1
          false-value=0
        )
          span {{conf.descripcion}}
    section(v-if="percepciones.length || deducciones.length")
      h4.title.is-4 Conceptos a incluir
      .columns.box
        .column
          table.table
            thead
              tr
                th Percepciones
                th Incluir
            tbody
              tr(v-for="p in percepciones")
                td {{p.descripcion}}
                td
                  .field
                    b-switch(
                        type="is-info"
                        v-model="conceptos[p.clave]"
                        true-value=1
                        false-value=0
                        )
        .column
          table.table
            thead
              tr
                th Deducciones
                th Incluir
            tbody
              tr(v-for="d in deducciones")
                td {{d.descripcion}}
                td
                  .field
                    b-switch(
                      type="is-info"
                      v-model="conceptos[d.clave]"
                      true-value=1
                      false-value=0
                    )
</template>
<script>
import { mapState } from 'vuex'
import EventBus from '@/utils/EventBus'
export default {
  name: 'Configuracion',
  props: ['config', 'tipo', 'useDefault', 'conceptos'],
  computed: {
    ...mapState([
      'catalogos'
    ]),
    tipoNomina () {
      return this.tipo ? this.tipo : {}
    },
    claves () {
      return this.configuracion.map(i => {
        return i.key
      })
      .concat(
        this.percepciones.map(i => {
          return i.clave
        }),
        this.deducciones.map(i => {
          return i.clave
        })
      )
    },
    configuracion () {
      const values = []
      const _config = this.catalogos.configuracion_nomina ? this.catalogos.configuracion_nomina : []
      Object.keys(_config).map(
        key => {
          const value = _config[key]
          let agregar = false
          if (value.aplica) {
            if (this.tipoNomina.aplica) {
              this.tipoNomina.aplica.some(e => {
                if (value.aplica.includes(e)) {
                  agregar = true
                }
              })
            }
          } else {
            agregar = true
          }
          if (agregar) {
            values.push({
              key,
              ...value
            })
            // valores por defecto
            if (this.useDefault) {
              this.$set(this.config, key, value.default ? 1 : 0)
            }
          }
        }
      )
      return values
    },
    percepciones () {
      return this.filtrarConceptos(this.catalogos.percepciones)
    },
    deducciones () {
      return this.filtrarConceptos(this.catalogos.deducciones)
    }
  },
  methods: {
    filtrarConceptos (conceptos) {
      const con = conceptos.filter(c => {
        if (!c.auto) {
          return false
        }
        if (c.aplicaEmp.length > 0) {
          if (this.tipoNomina.aplica) {
            return this.tipoNomina.aplica.some(e => {
              if (c.aplicaEmp.includes(e)) {
                return true
              }
            }) | false
          }
          return true
        }
        return true
      })
      if (this.useDefault) {
        con.map(c => {
          this.$set(this.conceptos, c.clave, 1)
        })
      }
      return con
    }
  },
  created () {
    // EventBus
    EventBus.$on('configuracion:requestClaves', evt => {
      EventBus.$emit('configuracion:sendClaves', this.claves)
    })
  }
}
</script>
