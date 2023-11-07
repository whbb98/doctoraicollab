import {createApp} from "vue";
import router from "@/router.js";
import App from "@/Layouts/App.vue";
import vuetify from "@/vuetify.js";

const app = createApp(App);
app.use(router);
app.use(vuetify)
app.mount('#app');
