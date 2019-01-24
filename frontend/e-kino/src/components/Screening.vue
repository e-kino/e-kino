<template>
  <div class="column is-one-quarter-desktop is-half-tablet">
    <div class="card">
      <div class="card-image">
        <figure class="image is-3by2">
          <img src="https://unsplash.it/300/200/?random&pic=3" alt="">
        </figure>
        <div class="card-content is-overlay is-clipped">
          <span class="tag  is-pulled-right">
            <b-icon
                    icon="clock"
                    size="is-small"
            ></b-icon>
            <span>{{showing.timeShow}}</span>
              </span>
        </div>
      </div>
      <div class="card-content">
        {{showing.movie.name}}
      </div>
      <footer class="card-footer">
        <router-link to="/booking/100" class="card-footer-item">
          Rezerwuj
        </router-link>
      </footer>
    </div>
  </div>
</template>

<script>
  import BIcon from "buefy/src/components/icon/Icon";

  export default {
    name: "Screening",
    components: {BIcon},
    props: {
      showing: Object
    }
  }
</script>

<style scoped>

</style>
