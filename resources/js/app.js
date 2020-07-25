import Vue from 'vue';
import axios from 'axios';
import router from './router';
import App from './Application';
import vuetify from './vuetify';
import store from './store';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.prototype.$http = axios;

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components: {
        'app': App
    }
});

export default app;
