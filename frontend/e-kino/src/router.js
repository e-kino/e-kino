import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Booking from './views/Booking.vue';
import MyBookings from './views/MyBookings.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/booking/:date/:showingId',
      name: 'booking',
      component: Booking
    },
    {
      path: '/my-bookings',
      name: 'myBookings',
      component: MyBookings
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './views/About.vue'),
    },
  ],
});
