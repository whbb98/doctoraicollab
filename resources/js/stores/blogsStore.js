import {defineStore} from "pinia";
import {useNotificationsStore} from "@/stores/notificationsStore.js";
import axios from "axios";
import {useAuthStore} from "@/stores/authStore.js";

export const useBlogsStore = defineStore('blogsStore', {
    state: () => ({
        blogs: []
    }),
    getters: {},
    actions: {
        async createNewBlog(APP_API_URL, blog) {
            const notificationsStore = useNotificationsStore()
            try {
                const formData = new FormData()
                blog?.title?.length > 0 && formData.append('title', blog.title)
                blog?.description?.length > 0 && formData.append('description', blog.description)
                if (blog?.participants?.length > 0) {
                    blog.participants.forEach((p,i) => formData.append(`participants[${i}]`, p))
                }
                if (blog.hasMeeting) {
                    formData.append('has_meeting', 1)
                    blog?.meetingDatetime && formData.append('scheduled', blog.meetingDatetime.replace('T', ' '))
                    blog?.meetingLink && formData.append('link', blog.meetingLink)
                    blog?.meetingDuration && formData.append('duration', blog.meetingDuration)
                }
                if (blog?.files?.length > 0) {
                    blog.files.forEach(file => formData.append('files[]', file))
                }
                const response = await axios.post(`${APP_API_URL}/blogs`,
                    formData,
                    {
                        headers: {
                            Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                            "Content-Type": "multipart/form-data"
                        }
                    })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'new blog!',
                        message: data.success
                    })
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'new blog!',
                        message: data.error
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                console.log(error)
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'blog creation failed!',
                    message: error.message
                })
                return false
            }
        },
        async fetchBlogs() {
        },
        async fetchBlogData() {
        }
    }
})
