<template>
  <div class="home">
    <section class="hero is-info">
      <div class="hero-body">
        <div class="container">
          <div class="card">
            <div class="card-content">
              <div class="content">
                <div class="control has-icons-left has-icons-right">
                  <label for="search">Wyszukaj seanse</label>
                  <b-datepicker
                          class="is-large"
                          v-model="date"
                          @input="fetchShowings"
                          placeholder="Wybierz datę, aby wyszukać seanse"
                          icon="calendar-today">
                  </b-datepicker>
                  <span class="icon is-medium is-left">
                            <i class="fa fa-search"></i>
                        </span>
                  <span class="icon is-medium is-right">
                            <i class="fa fa-empire"></i>
                        </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="container">
      <div class="columns is-multiline" style="margin-top: 30px">
        <screening v-for="showing in showings" :key="showing.id" :showing="showing" :date="date"></screening>
      </div>
    </section>
  </div>
</template>

<script>
  import Screening from '@/components/Screening'
  import axios from 'axios'
  import moment from 'moment'
  import {mapActions} from 'vuex'

  export default {
    name: 'home',
    components: {
      Screening
    },
    data() {
      return {
        showings: [],
        date: new Date()
      }
    },
    mounted() {
      this.fetchShowings()
    },
    methods: {
      ...mapActions([
        'setShowings'
      ]),
      fetchShowings() {
        let formattedDate = moment(this.date).format('YYYY-MM-DD');

        axios.get(`/showings/${formattedDate}`)
          .then((r) => {
            this.showings = r.data.showings
            this.setShowings(r.data.showings)
          })
      }
    }
  };
</script>

<style scoped>
  .has-padding-20 {
    padding: 20px !important;
  }
</style>
