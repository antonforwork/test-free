import Vue from 'vue'
import router from 'vue-router';

Vue.use(router);


import Rating from '../components/Rating/';

const routeList = [
    {
        path: '/',
        redirect: '/rating'
    },
    {path: '/rating', component: Rating, name: 'rating'},

]

export default new router({
    mode: 'hash',
    linkActiveClass: 'open active',
    routes: routeList
})
