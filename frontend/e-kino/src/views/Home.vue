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
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>
        <screening></screening>

      </div>
    </section>
  </div>
</template>

<script>
  import Screening from '@/components/Screening'

  export default {
    name: 'home',
    components: {
      Screening
    },
  };
</script>

<style scoped>
  .has-padding-20 {
    padding: 20px !important;
  }
</style>
