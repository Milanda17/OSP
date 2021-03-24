require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import { routes } from './router'


window.Vue = require('vue');
Vue.use(VueRouter)

let router = new VueRouter({
    mode: 'history',
    routes
});
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('id_token') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            next()
        }
    } else{
        next()
    }
})

const app = new Vue({
    el: '#app',
    router
});
