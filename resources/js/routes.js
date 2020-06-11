import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/js/stores';

import Home from '@/js/components/Home';
import Clients from '@/js/pages/clients';
import Loans from '@/js/pages/loans';
import Login from '@/js/pages/LoginPage';
import View from '@/js/views/View';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '',
            component: View,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: Home
                },
                {
                    path: '/clients',
                    name: 'clients',
                    component: Clients
                },
                {
                    path: '/loans',
                    name: 'loans',
                    component: Loans
                },
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        }
    ]
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.isAuthenticated;
    if (to.name !== 'login' && !isAuthenticated) next({ name: 'login'});
    else if (to.name === 'login' && isAuthenticated) next({ name: 'home' });
    else next();
});

export default router;
