import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import '@mdi/font/css/materialdesignicons.css'

const customTheme = {
    dark: false,
    colors: {
        primary: '#04AA6D',
        secondary: '#D9EEE1',
        dark: '#282A35',
        light:'#E7E9EB',
        gray: '#888888',
        error: '#B00020',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FB8C00',
    },
}

export default createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    theme: {
        defaultTheme:'customTheme',
        themes: {
            customTheme
        }
    },
})
