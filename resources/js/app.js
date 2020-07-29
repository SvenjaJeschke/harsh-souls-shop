import Vue from 'vue';
import axios from 'axios';
import router from './router';
import App from './Application';
import vuetify from './vuetify';
import store from './store';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Content-Type': 'application/json'
};

Vue.prototype.$http = axios;

let app;

store.dispatch('getUser').finally(() => mountApp());

function mountApp() {
    app = new Vue({
        el: '#app',
        router,
        vuetify,
        store,
        components: {
            'app': App
        }
    });
}

export default app;
