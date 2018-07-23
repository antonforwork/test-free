require('./bootstrap');

import router from './router/';

window.Vue = require('vue');
Vue.component('rating', require('./components/Rating/'));

const app = new Vue({
    router,
    el: '#app'
});
