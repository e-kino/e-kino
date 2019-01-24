<template>
  <div class="home">
    <section class="hero is-info">
      <div class="hero-body">
        <div class="container is-inline-flex">
          <div>
            <strong>
              <router-link to="/">
                <b-icon
                        icon="arrow-left"
                        size="is-small">
                </b-icon>
                Wróć
              </router-link>
            </strong>
          </div>
          <div style="margin-left: 200px">
            <strong>{{ currentShowing.movie.name }}</strong>
          </div>
        </div>
      </div>
    </section>
    <section class="container" style="margin-top: 30px">

      <div class="card">
        <div class="card-image">
          <figure class="image ">
            <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image"
                 style="max-height: 500px">
          </figure>
        </div>
        <div class="card-content">
          <div class="content">
            <div class="is-inline-flex">
              <div><strong>Wiek</strong></div>
              <div style="margin-left: 100px;">{{ currentShowing.movie.age }}</div>
            </div>
          </div>
          <div class="content">
            <div class="is-inline-flex">
              <div><strong>Opis</strong></div>
              <div style="margin-left: 100px;">{{ currentShowing.movie.description }}</div>
            </div>
          </div>
          <div class="content">
            <div class="is-inline-flex">
              <div><strong>Wybierz miejsce na sali kinowej</strong></div>
            </div>
          </div>

          <div class="content">
            <div class="columns">
              <div class="column">
                <p class="bd-notification" style="background: #cdcdcd;">Ekran</p>
              </div>
            </div>
            <div v-for="x in 6" class="columns">
              <div v-for="y in 10" class="column">
                <p class="bd-notification is-primary hoverable" :class="{'is-taken': y===2}" @click=toggleSeat(y*x)>{{ y * x }}</p>
              </div>
            </div>

          </div>
          <div class="content">
            <div class="columns" style="justify-content: center">
              <div class="column is-2">
                <p class="bd-notification" style="background: #cdcdcd;">Miejsce zajęte</p>
              </div>
              <div class="column is-2">
                <p class="bd-notification is-primary">Miejsce wolne</p>
              </div>
            </div>
          </div>
        </div>
        <footer class="card-footer">
          <a href="#" class="card-footer-item">Potwierdź rezerwację</a>
        </footer>
      </div>
    </section>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "Booking",
    data() {
      return {
        selectedSeat: null
      }
    },
    mounted() {

    },
    methods: {
      toggleSeat(seat) {
        if (this.selectedSeat === seat) {
          this.selectedSeat = null;
        } else {
          this.selectedSeat = seat;
        }
      }
    },
    computed: {
      currentShowing() {
        return this.showings.filter((s) => +s.id === +this.$route.params.showingId)[0]
      },
      ...mapState({
        showings: state => state.showings
      })
    }
  }
</script>

<style scoped>
  .bd-notification {
    background-color: #f5f5f5;
    border-radius: 4px;
    color: #7a7a7a;
    font-weight: 600;
    padding: 1.25rem 0;
    position: relative;
    text-align: center;
    cursor: pointer;
  }

  .bd-notification.hoverable:hover {
    background-color: #f57267 !important;
  }

  .bd-notification.is-taken:hover {
    background-color: #929292 !important;

  }

  .bd-notification.is-primary {
    background-color: #00d1b2;
    color: #fff;
  }
  
  .bd-notification.is-taken {
    background-color: #cfcfcf;
    color: #fff;
    cursor: not-allowed;
  }
</style>
