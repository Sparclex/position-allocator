require('./bootstrap');

import VueRouter from 'vue-router';
import PortalVue from 'portal-vue';

window.Vue = require('vue');
window.moment = require('moment-timezone');


Vue.use(VueRouter);
Vue.use(PortalVue);

Vue.filter("num2char", num => (num + 9).toString(36).toUpperCase())
// Register Components

const files = require.context('./components', true, /\.vue$/i);

files.keys().map(key => {
    let parts = key.split('/');
    return Vue.component(parts[parts.length - 1].split('.')[0], files(key));
});





let routes = [
    {
        path: '/',
        name: 'overview',
        component: require('./pages/Overview'),
        props: true,
    },
    {
        path: '/:view/:plate',
        name: 'overview-page',
        component: require('./pages/Overview'),
        props: true
    },
    {
        path: '/scanner',
        name: 'scanner',
        component: require('./pages/Scanner')
    }
];

let router = new VueRouter({mode: 'history', base: '/admin/', routes});

const app = new Vue({
    el: '#app',
    router
});
