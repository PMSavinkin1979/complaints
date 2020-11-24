/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import vuetify from './plugins/vuetify' // path to vuetify export
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import VueCharts from 'vue-chartjs'
import {Bar} from "vue-chartjs"
/*import ChartDataLabels from 'chartjs-plugin-datalabels'
Chart.plugins.unregister(ChartDataLabels);*/


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Setup.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(Vuex)
Vue.use(VueRouter)

Vue.component('setup', require('./components/Setup.vue').default);
Vue.component('test',require('./components/test.vue').default);
Vue.component('table-main',require('./components/TableMain.vue').default);
Vue.component('charts',require('./components/Charts').default);
Vue.component('status',require('./components/Status').default);
Vue.component('ustranenie',require('./components/Ustranenie').default);
Vue.component('vidgar',require('./components/Vidgar').default);
Vue.component('vina',require('./components/Vina').default);
Vue.component('any-chart',require('./components/AnyChart').default);
Vue.component('working-statuses',require('./components/WorkingStatuses').default);
Vue.component('purposes',require('./components/Purposes').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const Example = { template: '<table-main></table-main>'}
const Charts = { template: '<charts></charts>'}
const Setup = { template: '<setup></setup>'}
const routes = [
    { path: '/', component: Example, nameRouter: 'Рекламации' },
    { path: '/charts', component: Charts, nameRouter: 'Графики'  },
    { path: '/setup', component: Setup, nameRouter: 'Настройки'  },
]

const store = new Vuex.Store({
    state: {
        name:'',
        role:'',
        id:'',
        userBoolean: '',
        god:'2020',
        stat:'В работе',
        danye:[],
        snackbarMessage:'',
        snackbarBool: true,
        quarters:[] //кварталы
    },
    mutations: {
        SET_NAME: (state, payload) => {
            state.name = payload
        },
        SET_ROLE: (state, payload) => {
            state.role = payload
        },
        SET_ID: (state, payload) => {
            state.id = payload
        },
        SET_USERBOOLEAN: (state, payload) => {
            state.userBoolean = payload
        },
        SET_GOD: (state, payload) => {
            state.god = payload
        },
        SET_STAT: (state, payload) => {
            state.stat = payload
        },
        SET_DANYE: (state, payload) => {
            state.danye = payload
        },
        SET_SNACKBARMESSAGE: (state, payload) => {
            state.snackbarMessage = payload
        },
        SET_SNACKBARBOOL: (state, payload) => {
            state.snackbarBool = payload
        },
        SET_QUARTERS: (state, payload) => {
            state.quarters = payload
        },
    },
    getters:{
        NAME: state => {
            return state.name
        },
        ROLE: state => {
            return state.role
        },
        ID: state => {
            return state.id
        },
        USERBOOLEAN: state => {
            return state.userBoolean
        },
        GOD: state => {
            return state.god
        },
        STAT: state => {
            return state.stat
        },
        DANYE: state => {
            return state.danye
        },
        SNACKBARMESSAGE: state => {
            return state.snackbarMessage
        },
        SNACKBARBOOL: state => {
            return state.snackbarBool
        },
        QUARTERS: state => {
            return state.quarters
        },
    },
    actions:{
        SET_NAME: (injectee, payload) => {
            injectee.commit('SET_NAME',payload)
        },
        SET_USERBOOLEAN: (injectee, payload) => {
            injectee.commit('SET_USERBOOLEAN',payload)
        },
        SET_ID: (injectee, payload) => {
            injectee.commit('SET_ID',payload)
        },
        SET_ROLE: (injectee, payload) => {
            injectee.commit('SET_ROLE',payload)
        },
        SET_GOD: (injectee, payload) => {
            injectee.commit('SET_GOD',payload)
        },
        SET_STAT: (injectee, payload) => {
            injectee.commit('SET_STAT',payload)
        },
        SET_DANYE: (injectee, payload) => {
            injectee.commit('SET_DANYE',payload)
        },
        SET_SNACKBARMESSAGE: (injectee, payload) => {
            injectee.commit('SET_SNACKBARMESSAGE',payload)
        },
        SET_SNACKBARBOOL: (injectee, payload) => {
            injectee.commit('SET_SNACKBARBOOL',payload)
        },
        SET_QUARTERS: (injectee, payload) => {
            injectee.commit('SET_QUARTERS',payload)
        },
    }
})
const router = new VueRouter({
    routes
})
const app = new Vue({
    el: '#app',
    vuetify,
    store,
    router,
    VueCharts,
});

