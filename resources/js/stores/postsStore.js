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
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/posts`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.error) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'Posts',
                        message: data?.message ?? 'Error while loading posts data',
                    })
                } else {
                    this.posts = data
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'Posts loading',
                    message: error.message ?? 'Error while loading posts data',
                })
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
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'new post',
                        message: 'error while creating post!'
                    })
                    return false
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
        },
        async handlePostComment(APP_API_URL, postID, commentID, commentText) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/posts/${postID}/postComment`, {
                    comment_id: commentID !== null ? commentID : undefined,
                    comment: commentText
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'post comment!',
                        message: data.success
                    })
                    const postItem = this.posts.data.find(post => post.id === postID)
                    if (commentID !== null) {
                        const commentIndex = postItem.comments.findIndex(comment => comment.id === commentID)
                        postItem.comments.splice(commentIndex, 1)
                        postItem.comments.unshift(data.comment)
                    } else {
                        postItem.comments.unshift(data.comment)
                    }
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'post comment!',
                        message: data.message
                    })
                }
            } catch (e) {
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'post comment!',
                    message: 'error while creating post comment!'
                })
            }
        },
        async deleteComment(APP_API_URL, commentID) {
            // I forgot to add the logic of deleting comments in the backend, so I'll add it later
            try {

            } catch (e) {

            }
        },
    }
})
