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
            <strong>Moje rezerwacje</strong>
          </div>
        </div>
      </div>
    </section>
    <section class="container" style="margin-top: 30px">

      <div class="card">
        <div class="card-content">
          <div class="content">
            <div>
              <b-table :data="data" :columns="columns"></b-table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import {mapState} from 'vuex'
  import axios from 'axios'

  export default {
    name: "MyBooking",
    data() {
      return {
        bookings: [],
        data: [],
        columns: [
          {
            field: 'id',
            label: 'Numer rezerwacji',
            width: '180'
          },
          {
            field: 'showing.movie.name',
            label: 'Film',
          },
          {
            field: 'dateBooking',
            label: 'Data seansu',
          },
          {
            field: 'seatNumber',
            label: 'Numer miejsca',
            centered: true
          }
        ]
      }
    }
    ,
    mounted() {
      this.fetchBookings()
    }
    ,
    methods: {
      fetchBookings() {
        axios.get('/bookings/user')
          .then((r) => {
            this.data = r.data.bookings;
          })
      }
    }
    ,
    computed: {
      currentShowing() {
        return this.showings.filter((s) => +s.id === +this.$route.params.showingId)[0]
      }
      ,
      ...
        mapState({
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
