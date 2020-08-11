import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        redirect: { name: 'home' }
    },
    {
        name: 'home',
        path: '/home',
        component: () => import('./views/Home'),
        description: 'campaigns, discounts and new products'
    },
    {
        name: 'products',
        path: '/products',
        component: () => import('./views/ProductsShoppingOverview'),
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
        description: 'overview and management of all products',
        meta: {
            auth: true
        }
    },
    {
        name: 'category-management',
        path: '/admin/category-management',
        component: () => import('./views/admin/CategoryManagement'),
        description: 'overview and management of all categories',
        meta: {
            auth: true
        }
    },
    {
        name: 'orders',
        path: '/admin/orders',
        component: () => import('./views/admin/Orders'),
        description: 'overview of all orders',
        meta: {
            auth: true
        }
    },
    {
        name: 'edit-product',
        path: '/admin/product/:id/edit',
        component: () => import('./views/admin/EditProduct'),
        description: 'page with all product details and edit functionality',
        props: true,
        meta: {
            auth: true
        }
    },
    {
        name: 'product',
        path: '/product/:id',
        component: () => import('./views/ProductShoppingDetails'),
        description: 'product detail page with order options',
        props: true
    }
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.auth && !store.state.auth) {
        next({ name: 'home' });
    } else {
        next();
    }
});

export default router;
