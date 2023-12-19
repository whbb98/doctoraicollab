import {createRouter, createWebHistory} from 'vue-router';
import Home from "@/Pages/Home.vue";
import Profile from "@/Pages/Profile.vue";
import Messages from "@/Pages/Messages.vue";
import Notifications from "@/Pages/Notifications.vue";
import Blogs from "@/Pages/Blogs.vue";
import Meetings from "@/Pages/Meetings.vue";
import Network from "@/Pages/Network.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/', redirect: '/home',
        },
        {
            path: '/home', name: 'Home', component: Home,
            meta: {}
        },
        {
            path: '/profile', name: 'Profile', component: Profile,
            meta: {}
        },
        {
            path: '/messages', name: 'Messages', component: Messages,
            meta: {}
        },
        {
            path: '/notifications', name: 'Notifications', component: Notifications,
            meta: {}
        },
        {
            path: '/blogs', name: 'Blogs', component: Blogs,
            meta: {}
        },
        {
            path: '/meetings', name: 'Meetings', component: Meetings,
            meta: {}
        },
        {
            path: '/network', name: 'Network', component: Network,
            meta: {}
        }

    ],
})

router.beforeEach((to, from, next) => {
    document.title = `${import.meta.env.VITE_APP_NAME} - ${to.name}`
    next()
})
export default router
