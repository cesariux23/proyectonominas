<template lang="html">
  <div class="column" :class="clase">
    <label class="label">{{encabezado}}</label>
    <span>
      <slot></slot>
    </span>
  </div>

</template>

<script>
export default {
  name: 'ColumnDato',
  props: ['encabezado', 'clase']
}
</script>

<style lang="css">
</style>
