import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        redirect: {name: 'home'}
    },
    {
        name: 'home',
        path: '/home',
        component: () => import('./views/Home'),
        description: 'campaigns, discounts and new products'
    },
    {
        name: 'products-list',
        path: '/products/:category/:sort?/:color?/:pricerange?/:search?',
        component: () => import('./views/ProductsList'),
        description: 'products overview with search, filter and sorting options'
    }
];

const router = new VueRouter({
    routes
});

export default router;
