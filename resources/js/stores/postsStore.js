import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "@/stores/authStore.js";
import {da} from "vuetify/locale";

export const usePostsStore = defineStore('postsStore', {
    state: () => ({
        posts: []
    }),
    getters: {},
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
                return data
            }
        },
        async createNewPost(APP_API_URL, postObj) {
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
                    return {
                        open: true,
                        type: 'success',
                        title: 'new post',
                        message: data.success
                    }
                } else {
                    console.warn(data)
                }
            } catch (e) {
                const error = e.response.data
                return {
                    open: true,
                    type: 'error',
                    title: 'post creation failed!',
                    message: error.message
                }
            }
        }
    }
})
