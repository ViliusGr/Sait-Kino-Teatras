import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Movies from './components/Movies.vue';
import Screenings from './components/Screenings.vue';
import Auditoria from './components/Auditoria.vue';
import Tickets from './components/Tickets.vue';

Vue.use(Router);

export const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home
    },
    {
      path: '/home',
      component: Home
    },
    {
      path: '/login',
      component: Login
    },
    {
      path: '/register',
      component: Register
    },
    {
      path: '/movies',
      component: Movies
    },
    {
      path: '/movies/:movie_id/screenings',
      component: Screenings
    },
    {
      path: '/auditoria',
      component: Auditoria
    },
    {
      path: '/users/:user_id/tickets',
      component: Tickets
    }
  ]
});

/*router.beforeEach((to, from, next) => {
    const publicPages = ['/login', '/register', '/home'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');
  
    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn) {
      next('/login');
    } else {
      next();
    }
  });*/
