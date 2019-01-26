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
            <strong>{{ currentShowing.movie.name }} - {{ $route.params.date }} {{ currentShowing.timeShow }}</strong>
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
                <p class="bd-notification is-primary hoverable"
                   :x="x"
                   :class="{'is-taken': isTaken(x*10+y-10), 'is-selected': isSelected(x*10+y-10)}" @click=toggleSeat(x*10+y-10)>
                  {{ x*10+y-10 }}
                </p>
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
          <div class="card-footer-item">
            <router-link to="/" class="is-large button">
              Wróć do wyszukiwarki
            </router-link>
          </div>
          <div class="card-footer-item">
            <a class="is-primary is-large button" @click="confirmBooking">
              Potwierdź rezerwację
            </a>
          </div>
        </footer>
      </div>
    </section>

    <b-modal :active.sync="confirmModal" has-modal-card>
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Potwierdzenie rezerwacji</p>
        </header>
        <section class="modal-card-body">
          <div style="font-size: 23pt; margin-bottom: 20px">
            {{currentShowing.movie.name}} {{currentShowing.timeShow}}
          </div>

          <div v-for="booking in bookings">
            <strong>Rezerwacja nr {{booking.id}}:</strong> <span class="is-pulled-right">miejsce {{booking.seatNumber}}</span>
          </div>


        </section>
        <footer class="modal-card-foot" style="justify-content: space-between">
          <button class="button" type="button" @click="confirmModal = false">Zamknij</button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
  import {mapState} from 'vuex'
  import axios from 'axios'

  export default {
    name: "Booking",
    data() {
      return {
        selectedSeats: [],
        takenSeats: [],
        seatStart: 1,
        confirmModal: false,
        bookings: []
      }
    },
    mounted() {
      this.fetchTakenSeats()
    },
    methods: {
      toggleSeat(seat) {
        if (this.isTaken(seat)) {
          this.$snackbar.open(`Miejsce ${seat} jest zajęte.`);
          return
        }

        let indexOf = this.selectedSeats.indexOf(seat);

        if (indexOf > -1) {
          this.selectedSeats.splice(indexOf, 1);
        } else {
          this.selectedSeats.push(seat);
        }
      },
      fetchTakenSeats() {
        return axios.get(`/showings/seats/taken/${this.$route.params.showingId}`)
          .then((r) => {
            this.takenSeats = r.data.takenSeats;
          })
      },
      isSelected(seat) {
        return this.selectedSeats.indexOf(seat) !== -1
      },
      isTaken(seat) {
        return this.takenSeats.indexOf(seat) !== -1
      },
      confirmBooking() {
        if (!this.selectedSeats.length) {
          this.$snackbar.open(`Musisz wybrać przynajmniej jedno miejsce.`);
          return;
        }

        axios.post('/bookings', {
          seats: this.selectedSeats,
          showingId: this.$route.params.showingId,
          dateBooking: this.$route.params.date + ' ' + this.currentShowing.timeShow
        })
          .then((r) => {
            this.bookings = r.data.bookings;
            this.confirmModal = true;
            this.fetchTakenSeats().then(() => {
              this.selectedSeats = [];
            });
          })

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

  .bd-notification.hoverable.is-selected:hover {
    background-color: red !important;
  }

  .bd-notification.is-taken:hover {
    background-color: #929292 !important;
  }

  .bd-notification.is-selected {
    background-color: #f57267 !important;
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
