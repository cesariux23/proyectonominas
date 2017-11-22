<template lang='pug'>
	.columns
		.column.is-half.is-offset-one-quarter
			.card
					header.card-header
						p.card-header-title Iniciar sesión
					.card-content
						form
							.field
								label Usuario
								.control
									input.input(type="text" name="username")
							.field
								label Contraseña
								.control
									input.input(type="password" name="password")
							.field.is-grouped
								.control
									button.button.is-primary(type="submit")
										span.icon
											i.fa.fa-sign-in
										span Iniciar sesión
</template>
<script>
	export default {
	  name: 'Login'
	}
</script>
