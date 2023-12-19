import {createApp} from "vue"
import router from "@/router.js"
import App from "./App.vue"
import vuetify from "@/vuetify.js"
import {createPinia} from "pinia"

const app = createApp(App);
app.use(router)
app.use(vuetify)
app.use(createPinia())
app.mount('#app');
