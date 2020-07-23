import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/lib';
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify);

const options = {
    theme: {
        dark: true,
        themes: {
            dark: {
                primary: '#D32F2F',
                secondary: '#EC407A',
                error: '#FFC107'
            }
        }
    },
    icons: {
        iconfont: 'mdi'
    }
};

export default new Vuetify(options);
