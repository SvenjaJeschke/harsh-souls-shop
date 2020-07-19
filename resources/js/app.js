import Vue from 'vue';
import axios from 'axios';
import router from './router';
import App from './Application';
import vuetify from './vuetify';

Vue.prototype.$http = axios;

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    components: {
        'app': App
    }
});

export default app;
