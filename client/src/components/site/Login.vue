<template lang='pug'>
  .LoginForm
    h3.title.is-3.has-text-centered Sistema de Recursos Humanos
    .columns
      .column.is-half.is-offset-one-quarter
        .card
            header.card-header
              p.card-header-title Iniciar sesión
            .card-content
              form(@submit.prevent="authenticate")
                b-field(label = "Usuario")
                  b-input(v-model="user.username" required)
                b-field(label = "contraseña")
                  b-input(
                    type="password"
                    v-model="user.password"
                    password-reveal
                    required)
                .field.is-grouped
                  .control
                    button.button.is-primary(type="submit")
                      span.icon
                        i.fa.fa-sign-in
                      span Iniciar sesión
</template>
<script>
  import { mapActions } from 'vuex'
  export default {
    name: 'Login',
    data () {
      return {
        user: {},
        isLoading: false
      }
    },
    methods: {
      authenticate () {
        this.login(this.user).then((response) => {
          this.$router.push('/')
        })
        .catch((error) => {
          this.$toast.open({
            duration: 5000,
            message: error.data.error,
            position: 'is-top-right',
            type: 'is-danger'
          })
        })
      },
      ...mapActions([
        'login'
      ])
    }
  }
</script>
