<template>
  <div id="app" class="is-flex" style="flex-direction: column">
    <nav class="navbar has-shadow">
      <div class="container">
        <div class="navbar-brand"><a class="navbar-item" href="../">E-kino</a>
          <div class="navbar-burger burger" data-target="navMenu"><span></span><span></span><span></span></div>
        </div>
        <div class="navbar-menu" id="navMenu">
          <div class="navbar-end">
            <div class="navbar-item is-hoverable">

              <a @click="isComponentModalActive = true">Zaloguj się</a>
            </div>
            <div class="navbar-item is-hoverable">
              <a href="">Zarejestruj się</a>
            </div>

            <div class="navbar-item has-dropdown is-hoverable"><a class="navbar-link">Account</a>
              <div class="navbar-dropdown"><a class="navbar-item">Dashboard</a><a class="navbar-item">Profile</a><a
                      class="navbar-item">Settings</a>
                <hr class="navbar-divider"/>
                <div class="navbar-item">Logout</div>
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
      <form action="">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Zaloguj się</p>
          </header>
          <section class="modal-card-body">
            <b-field label="Email">
              <b-input
                      type="email"
                      :value="email"
                      placeholder="Email"
                      required>
              </b-input>
            </b-field>

            <b-field label="Hasło">
              <b-input
                      type="password"
                      :value="password"
                      password-reveal
                      placeholder="Hasło"
                      required>
              </b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot" style="justify-content: space-between">
            <button class="button" type="button" @click="isComponentModalActive = false">Zamknij</button>
            <button class="button is-primary">Zaloguj się</button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isComponentModalActive: false,
        email: '',
        password: ''
      }
    }
  }

</script>

<style>
  html, body, #app {
    height: 100%;
  }
</style>
