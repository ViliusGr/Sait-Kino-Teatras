
require('./bootstrap');

import Vue from 'vue'
import App from './App.vue';
import VueRouter from 'vue-router'
import { router } from './router';
import store from './vuex';
import './axios'
import { Datetime } from 'vue-datetime'
import { Settings } from 'luxon'

//set to display dates for English language

// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
 
window.Vue = require('vue').default;

Settings.defaultLocale = 'lt'
Vue.use(Datetime);
 

const app = new Vue({
    router,
    store,
    render: h => h(App),
    el: '#app',
});
