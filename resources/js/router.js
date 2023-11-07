import {createRouter,createWebHistory} from 'vue-router'
import App from "@/Layouts/App.vue";

const router = createRouter({
    history:createWebHistory(),
    routes:[
        {path:'/', component:{App}}
    ],
})

export default router
