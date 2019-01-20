<template>
  <div id="app">
    <nav class="navbar has-shadow">
      <div class="container">
        <div class="navbar-brand"><a class="navbar-item" href="../">E-kino</a>
          <div class="navbar-burger burger" data-target="navMenu"><span></span><span></span><span></span></div>
        </div>
        <div class="navbar-menu" id="navMenu">
          <div class="navbar-end">
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
    <section class="hero is-info">
      <div class="hero-body">
        <div class="container">
          <div class="card">
            <div class="card-content">
              <div class="content">
                <div class="control has-icons-left has-icons-right">
                  <label for="search">Wyszukaj seanse</label>
                  <input id="search" class="input is-large" type="date"/>
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
      <div class="level-item">
        <router-view/>
      </div>
    </section>
    <div class="columns is-mobile is-centered">
      <div class="column is-half is-narrow"></div>
    </div>
    <footer>
      <div class="box cta">
        <div class="columns is-mobile is-centered">
          <div class="field is-grouped is-grouped-multiline">
            <div class="control">
              <div class="tags has-addons"><a class="tag is-link" href="https://github.com/e-kino/e-kino">e-kino</a><span class="tag is-light">github</span></div>
            </div>
          </div>
        </div>
      </div>
    </footer>

  </div>
</template>

<style>

</style>
