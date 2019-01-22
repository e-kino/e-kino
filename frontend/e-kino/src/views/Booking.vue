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
            <span>Tytuł filmu</span>
          </div>
        </div>
      </div>
    </section>
    <section class="container" style="margin-top: 30px">

      <div class="card">
        <div class="card-content">
          <div class="content">
            <div class="is-inline-flex">
              <div>a</div>
              <div style="margin-left: 100px;">b</div>
            </div>
          </div>
          <div class="content">
            <div class="is-inline-flex">
              <div>a</div>
              <div style="margin-left: 100px;">b</div>
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
  export default {
    name: "Booking"
  }
</script>

<style scoped>

</style>
