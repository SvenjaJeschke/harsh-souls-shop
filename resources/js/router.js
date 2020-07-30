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
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('./views/LoginForm'),
        description: 'login for the administration area'
    },
    {
        name: 'product-management',
        path: '/admin/product-management',
        component: () => import('./views/admin/ProductManagement'),
        description: 'overview and management of all products'
    },
    {
        name: 'category-management',
        path: '/admin/category-management',
        component: () => import('./views/admin/CategoryManagement'),
        description: 'overview and management of all categories'
    },
    {
        name: 'orders',
        path: '/admin/orders',
        component: () => import('./views/admin/Orders'),
        description: 'overview of all orders'
    },
    {
        name: 'edit-product',
        path: '/admin/product/:id/edit',
        component: () => import('./views/admin/EditProduct'),
        description: 'page with all product details and edit functionality',
        props: true
    }
];

const router = new VueRouter({
    routes
});

export default router;
