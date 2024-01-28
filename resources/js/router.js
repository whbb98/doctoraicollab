import {createRouter, createWebHistory} from 'vue-router';
import Home from "@/pages/Home.vue";
import Profile from "@/pages/Profile.vue";
import Messages from "@/pages/Messages.vue";
import Notifications from "@/pages/Notifications.vue";
import Blogs from "@/pages/Blogs.vue";
import Meetings from "@/pages/Meetings.vue";
import Network from "@/pages/Network.vue";
import BlogDetails from "@/components/BlogDetails.vue";
import Signin from "@/pages/signin.vue";
import Signup from "@/pages/signup.vue";
import Dashboard from "@/pages/Dashboard.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: Dashboard,
            redirect: '/home',
            children: [
                {
                    path: '/home',
                    name: 'home',
                    component: Home,
                    meta: {}
                },
                {
                    path: '/profile',
                    name: 'profile',
                    component: Profile,
                    meta: {}
                },
                {
                    path: '/profile/:username',
                    name: 'profileView',
                    component: Profile,
                    meta: {}
                },
                {
                    path: '/messages',
                    name: 'messages',
                    component: Messages,
                    meta: {}
                },
                {
                    path: '/notifications',
                    name: 'notifications',
                    component: Notifications,
                    meta: {}
                },
                {
                    path: '/blogs',
                    name: 'blogs',
                    component: Blogs,
                    meta: {}
                },
                {
                    path: '/blogs/:blogID',
                    name: 'blogDetails',
                    component: BlogDetails
                },
                {
                    path: '/meetings',
                    name: 'meetings',
                    component: Meetings,
                    meta: {}
                },
                {
                    path: '/network',
                    name: 'network',
                    component: Network,
                    meta: {}
                }
            ]
        },
        {
            path: '/login',
            redirect: '/signin',
        },
        {
            path: '/signin',
            name: 'signin',
            component: Signin,
            meta: {}
        },
        {
            path: '/signup',
            name: 'signup',
            component: Signup,
            meta: {}
        },
    ],
})

router.beforeEach((to, from, next) => {
    document.title = `${import.meta.env.VITE_APP_NAME} - ${to.name}`
    next()
})
export default router
