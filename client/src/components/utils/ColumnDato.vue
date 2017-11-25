<template lang="pug">
  .column(:class="clase")
    label.label {{encabezado}}
    span.upper
      slot
</template>

<script>
export default {
  name: 'ColumnDato',
  props: ['encabezado', 'clase']
}
</script>

<style lang="css">
	.upper{
		text-transform: uppercase;
	}
</style>
