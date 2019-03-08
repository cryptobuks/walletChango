/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Vue.use(VueRouter)


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

let routes = [
    {path: '/chama', component: require('./components/Chamaa.vue').default},
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app', router
});
