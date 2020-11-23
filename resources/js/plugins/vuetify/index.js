import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'
//import '@mdi/font/css/materialdesignicons.css'

import ru from 'vuetify/es5/locale/ru'

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
            light: {
                primary: colors.blue.darken3,
            },
        },
    },
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
    lang: {
        locales: { ru },
        current: 'ru'
    }
}

export default new Vuetify(opts)
