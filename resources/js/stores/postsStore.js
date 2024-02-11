import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "@/stores/authStore.js";
import {useNotificationsStore} from "@/stores/notificationsStore.js";

export const usePostsStore = defineStore('postsStore', {
    state: () => ({
        posts: []
    }),
    getters: {
        getPosts() {
            return this.posts
        }
    },
    actions: {
        async fetchPosts(APP_API_URL) {
            const response = await axios.get(`${APP_API_URL}/posts`, {
                headers: {
                    Authorization: `Bearer ${useAuthStore().getAuthToken}`
                }
            })
            const data = response.data
            if (data.error) {
                console.error(data.error)
            } else {
                this.posts = data
            }
        },
        async createNewPost(APP_API_URL, postObj) {
            const notificationsStore = useNotificationsStore()
            try {
                const formData = new FormData()
                formData.append('description', postObj.description ?? '')
                formData.append('visibility', postObj.visibility ? '1' : '0')
                if (postObj?.files?.length > 0) {
                    postObj.files.forEach(file => formData.append('files[]', file))
                }
                const response = await axios.post(`${APP_API_URL}/posts`,
                    formData,
                    {
                        headers: {
                            Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                            "Content-Type": "multipart/form-data"
                        }
                    })
                const data = response.data
                if (data.success) {
                    this.posts.data.unshift(data.post)
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'new post',
                        message: data.success
                    })
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'new post',
                        message: 'error while creating post!'
                    })
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'post creation failed!',
                    message: error.message
                })
            }
        },
        async deletePost(APP_API_URL, postID) {
            const notificationsStore = useNotificationsStore()
            const postIndex = this.posts.data.findIndex(item => item.id === postID)
            try {
                const response = await axios.delete(`${APP_API_URL}/posts/${postID}`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                    }
                })
                const data = response.data
                if (data.success) {
                    this.posts.data.splice(postIndex, 1)
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'post deletion!',
                        message: data.success
                    })
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'post deletion!',
                        message: data.error
                    })
                }
            } catch (e) {
                console.error(e)
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'post deletion!',
                    message: 'error while deleting post'
                })
            }
        }
    }
})
