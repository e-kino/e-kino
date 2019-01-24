<template>
  <div id="app" class="is-flex" style="flex-direction: column">
    <nav class="navbar has-shadow">
      <div class="container">
        <div class="navbar-brand"><a class="navbar-item" href="../">E-kino</a>
          <div class="navbar-burger burger" data-target="navMenu"><span></span><span></span><span></span></div>
        </div>
        <div class="navbar-menu" id="navMenu">
          <div class="navbar-end">
            <div v-if="!isLoggedIn" class="navbar-item is-hoverable">

              <a @click="isComponentModalActive = true">Zaloguj się</a>
            </div>
            <div v-if="!isLoggedIn" class="navbar-item is-hoverable">
              <a href="">Zarejestruj się</a>
            </div>

            <div v-if="isLoggedIn" class="navbar-item has-dropdown is-hoverable"><a class="navbar-link">Konto</a>
              <div class="navbar-dropdown"><a class="navbar-item">Dashboard</a>
                <a class="navbar-item">Rezerwacje</a>
                <hr class="navbar-divider"/>
                <a class="navbar-item" @click="logout">Wyloguj się</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <router-view/>
    <div style="flex-grow: 1"></div>
    <div class="columns is-mobile is-centered">
      <div class="column is-half is-narrow"></div>
    </div>
    <footer>
      <div class="box cta">
        <div class="columns is-mobile is-centered">
          <div class="field is-grouped is-grouped-multiline">
            <div class="control">
              <div class="tags has-addons"><a class="tag is-link"
                                              href="https://github.com/e-kino/e-kino">e-kino</a><span
                      class="tag is-light">github</span></div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <b-modal :active.sync="isComponentModalActive" has-modal-card>
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Zaloguj się</p>
        </header>
        <section class="modal-card-body">
          <b-field label="Email">
            <b-input
                    type="email"
                    v-model="email"
                    placeholder="Email"
                    required>
            </b-input>
          </b-field>

          <b-field label="Hasło">
            <b-input
                    type="password"
                    v-model="password"
                    password-reveal
                    placeholder="Hasło"
                    @keyup.enter.native="login"
                    required>
            </b-input>
          </b-field>
        </section>
        <footer class="modal-card-foot" style="justify-content: space-between">
          <button class="button" type="button" @click="isComponentModalActive = false">Zamknij</button>
          <button class="button is-primary" @click="login">Zaloguj się</button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        isLoggedIn: false,
        isComponentModalActive: false,
        email: '',
        password: ''
      }
    },
    methods: {
      login() {
        if (this.email.length && this.password.length) {
          axios.post('/login', {
            email: this.email,
            password: this.password
          })
            .then((r) => {
              if (r.data.error === 0) {
                this.$snackbar.open(r.data.message);
                this.isComponentModalActive = false;
                this.isLoggedIn = true;
              } else {
                this.$snackbar.open({
                  message: r.data.message,
                  type: 'is-danger'
                })
              }
            })
        }
      },
      logout() {
        axios.post('/logout')
          .then((r) => {
            this.$snackbar.open(r.data.message);
            this.isLoggedIn = false;
          })
      }
    }
  }

</script>

<style>
  html, body, #app {
    height: 100%;
  }
</style>
