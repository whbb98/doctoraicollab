import {createRouter, createWebHistory, useRouter} from 'vue-router';
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
import {useAuthStore} from "@/stores/authStore.js";
import {useProfileStore} from "@/stores/profileStore.js";

const ENV = {
    APP_URL: import.meta.env.VITE_APP_URL,
    APP_API_URL: import.meta.env.VITE_APP_API_URL,
}

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
                    name: 'Home',
                    component: Home,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/profile',
                    name: 'Profile',
                    component: Profile,
                    meta: {requiresAuth: true},
                    async beforeEnter(to, from, next) {
                        const profileStore = useProfileStore()
                        if (profileStore.getAuthUserProfile === null) {
                            await profileStore.fetchAuthUserProfile(ENV.APP_API_URL)
                        }
                        if (profileStore.getAuthUserProfile !== null) {
                            next(true)
                        } else {
                            next(false)
                        }
                    }
                },
                {
                    path: '/profile/:username',
                    name: 'ProfileView',
                    component: Profile,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/messages',
                    name: 'Messages',
                    component: Messages,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/notifications',
                    name: 'Notifications',
                    component: Notifications,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/blogs',
                    name: 'Blogs',
                    component: Blogs,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/blogs/:blogID',
                    name: 'BlogDetails',
                    component: BlogDetails,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/meetings',
                    name: 'Meetings',
                    component: Meetings,
                    meta: {requiresAuth: true}
                },
                {
                    path: '/network',
                    name: 'Network',
                    component: Network,
                    meta: {requiresAuth: true}
                }
            ]
        },
        {
            path: '/login',
            redirect: '/signin',
        },
        {
            path: '/signin',
            name: 'Signin',
            component: Signin,
            meta: {requiresAuth: false}
        },
        {
            path: '/signup',
            name: 'Signup',
            component: Signup,
            meta: {requiresAuth: false}
        },
        {
            path: '/:notFound(.*)',
            redirect: '/'
        }
    ],
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()
    document.title = `${import.meta.env.VITE_APP_NAME} - ${to.name}`
    if (!to.meta.requiresAuth) {
        if (authStore.getAuthToken !== null) {
            return next('/')
        }
        return next()
    }
    if (to.meta.requiresAuth && authStore.getAuthToken) {
        return next()
    } else {
        return next('/signin')
    }
})
export default router
