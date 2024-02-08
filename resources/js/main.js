import {createApp, markRaw} from "vue"
import router from "@/router.js"
import App from "./App.vue"
import vuetify from "@/vuetify.js"
import {createPinia} from "pinia"

const pinia = createPinia()
const app = createApp(App);

app.use(pinia)
pinia.use(({store}) => {
    store.$router = markRaw(router)
})
app.use(router)
app.use(vuetify)
app.mount('#app');
