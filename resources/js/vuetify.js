import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/lib';
import '@mdi/font/css/materialdesignicons.css';
import '@fortawesome/fontawesome-free/css/all.css';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

const options = {
    theme: {
        dark: true,
        themes: {
            dark: {
                primary: '#D32F2F',
                secondary: '#fc2d73',
                error: '#FFC107',
                highlight: '#4e4e4e'
            }
        }
    },
    icons: {
        iconfont: 'fa' || 'mdi'
    }
};

export default new Vuetify(options);
