/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import store from './store/store'
import routes from './routes'
import {AlertError, Form, HasError} from 'vform'
import swal from 'sweetalert2'



window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(VueRouter)
Vue.use(Vuex)



window.Fire = new Vue();

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const router = new VueRouter({
    mode: 'history',
    history: true,
    routes
})


Vue.filter('custom_date', function (date) {
    return moment(date).format('MMMM Do YYYY');
})
Vue.filter('custom_user_type', function (type) {
    var return_type = ""

    if (type == 1) {
        return_type = "Admin";
    } else if (type == 2) {
        return_type = "Standard User";
    } else if (type == 3) {
        return_type = "Author";
    }
    return return_type;
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router,
    store: store

});
