<template lang="pug">
  .box(v-if="empleado.id")
    .columns.is-underlined
      .column
        h3.title.is-4 {{empleado.datos_personales.nombre_completo}}
        .detail
          b Núm. empleado:
          |  {{empleado.numero_empleado}} /
          b  RFC:
          |  {{empleado.datos_personales.rfc}}
      .column.is-3
        b-field(grouped position="is-right")
          p.control
            span.tag.is-medium.is-success {{empleado.status}}
          p.control
            span.tag.is-medium.is-black {{empleado.tipo_contrato}}
          p.control(v-if="empleado.tipo_nombramiento")
              span.tag.is-medium.is-warning {{empleado.tipo_nombramiento}}
    .columns
      column-dato(encabezado="Clave" v-if="empleado.puesto_actual.plaza")
        | {{empleado.puesto_actual.plaza.clave}}
      column-dato(encabezado="Puesto" v-if="empleado.puesto_actual.plaza")
        | {{empleado.puesto_actual.plaza.nombre}}
      column-dato(encabezado="Función") {{empleado.puesto_actual.funcion}}
      column-dato(encabezado="Adscripción" v-if="empleado.puesto_actual.adscripcion")
        | {{empleado.puesto_actual.adscripcion.nombre}}
      column-dato(encabezado="Desde") {{empleado.puesto_actual.fecha_inicio}}
      .column(v-if="baja")
        b-field(label="Finaliza")
          b-input(
            type="date"
            v-model="empleado.puesto_actual.fecha_fin"
            required)
</template>
<script>
  import ColumnDato from '@/components/utils/ColumnDato'
  export default {
    name: 'HeaderEmpleado',
    props: ['empleado', 'baja'],
    components: {
      ColumnDato
    }
  }
</script>
