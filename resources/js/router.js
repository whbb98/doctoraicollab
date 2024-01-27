import {createRouter, createWebHistory} from 'vue-router';
import Home from "@/pages/Home.vue";
import Profile from "@/pages/Profile.vue";
import Messages from "@/pages/Messages.vue";
import Notifications from "@/pages/Notifications.vue";
import Blogs from "@/pages/Blogs.vue";
import Meetings from "@/pages/Meetings.vue";
import Network from "@/pages/Network.vue";
import BlogDetails from "@/components/BlogDetails.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            redirect: '/home',
        },
        {
            path: '/home',
            name: 'Home',
            component: Home,
            meta: {}
        },
        {
            path: '/profile',
            name: 'Profile',
            component: Profile,
            meta: {}
        },
        {
            path: '/profile/:username',
            name: 'ProfileView',
            component: Profile,
            meta: {}
        },
        {
            path: '/messages',
            name: 'Messages',
            component: Messages,
            meta: {}
        },
        {
            path: '/notifications',
            name: 'Notifications',
            component: Notifications,
            meta: {}
        },
        {
            path: '/blogs',
            name: 'Blogs',
            component: Blogs,
            meta: {}
        },
        {
            path: '/blogs/:blogID',
            name: 'BlogDetails',
            component: BlogDetails
        },
        {
            path: '/meetings',
            name: 'Meetings',
            component: Meetings,
            meta: {}
        },
        {
            path: '/network',
            name: 'Network',
            component: Network,
            meta: {}
        }

    ],
})

router.beforeEach((to, from, next) => {
    document.title = `${import.meta.env.VITE_APP_NAME} - ${to.name}`
    next()
})
export default router
