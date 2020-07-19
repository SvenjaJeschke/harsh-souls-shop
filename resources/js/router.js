import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
        name: 'home',
        path: '/',
        description: 'campaigns, discounts and new products'
    }
];

const router = new VueRouter({
    routes
});

export default router;
