import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/lib';

Vue.use(Vuetify);

const options = {
    theme: {
        dark: true,
        themes: {
            dark: {
                primary: '#fd2929'
            }
        }
    }
};

export default new Vuetify(options);
