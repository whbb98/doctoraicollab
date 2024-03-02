import {defineStore} from "pinia";
import {useNotificationsStore} from "@/stores/notificationsStore.js";
import axios from "axios";
import {useAuthStore} from "@/stores/authStore.js";
import {useRouter} from "vue-router";
import {da} from "vuetify/locale";

export const useBlogsStore = defineStore('blogsStore', {
    state: () => ({
        blogs: []
    }),
    getters: {
        getBlogs() {
            return this.blogs
        },
        getMeetingBlogs() {
            return this.getBlogs.filter(blog => blog.has_meeting)
        }
    },
    actions: {
        async createNewBlog(APP_API_URL, blog) {
            const notificationsStore = useNotificationsStore()
            try {
                const formData = new FormData()
                blog?.title?.length > 0 && formData.append('title', blog.title)
                blog?.description?.length > 0 && formData.append('description', blog.description)
                if (blog?.participants?.length > 0) {
                    blog.participants.forEach((p, i) => formData.append(`participants[${i}]`, p))
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
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'blog creation failed!',
                    message: error.message
                })
                return false
            }
        },
        async fetchBlogs(APP_API_URL) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/blogs`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                this.blogs = data.data
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'fetching blogs records!',
                    message: error.message
                })
            }
        },
        async fetchBlogData(APP_API_URL, blogID) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (!data.error) {
                    const blog = data.data
                    const currentParticipant = blog.participants.find(p => p.username === useAuthStore().getUser.username)
                    const participants = blog.participants.filter(p => p.username !== useAuthStore().getUser.username)
                    participants.unshift(currentParticipant)
                    blog.participants = participants
                    return blog
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'fetching blog data!',
                        message: data.error
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                console.log(e)
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'fetching blog data!',
                    message: error.message
                })
                return false
            }
        },
        async storeAnnotation(APP_API_URL, blogID, imageID, annotation) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/blogs/${blogID}/imageAnnotation`, {
                    'image_id': imageID,
                    'annotation': JSON.stringify(annotation)
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'image annotation!',
                        message: data.success
                    })
                    return false
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'image annotation!',
                        message: data.error
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'image annotation!',
                    message: error.message
                })
                return false
            }
        },
        async getAnnotations(APP_API_URL, blogID, userID, imageID) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}/imageAnnotation`, {
                    params: {
                        image_id: imageID,
                        user_id: userID
                    },
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data?.annotation) {
                    return JSON.parse(data.annotation)
                } else {
                    return []
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'fetching image annotations!',
                    message: error.message
                })
                return []
            }
        },
        async fetchComments(APP_API_URL, blogID) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}/blogComment`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data) {
                    return data
                } else {
                    return []
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'blog comments!',
                    message: 'error while fetching blog comments!'
                })
            }
        },
        async storeComment(APP_API_URL, blogID, commentID, commentText) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/blogs/${blogID}/blogComment`, {
                    comment_id: commentID ?? undefined,
                    comment: commentText
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'blog comment!',
                        message: data.success
                    })
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'blog comment!',
                        message: data?.message
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'error while inserting comment!',
                    message: error.message
                })
                return false
            }
        },
        async deleteComment(APP_API_URL, blogID, commentID) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.delete(`${APP_API_URL}/blogs/${blogID}/deleteComment`, {
                    params: {
                        comment_id: commentID
                    },
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'comment delete!',
                        message: data.success
                    })
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'comment delete!',
                        message: data.error
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'delete comment!',
                    message: error.message
                })
                return false
            }
        },
        async fetchICDAutoSuggestions(APP_API_URL, blogID, query) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}/icd10_auto_complete`, {
                    params: {
                        q: query
                    },
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.length > 0) {
                    return data
                } else {
                    return null
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'fetching ICD10 suggestions!',
                    message: error.message
                })
                return null
            }
        },
        async storeBlogFeedback(APP_API_URL, blogID, feedbackData) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/blogs/${blogID}/feedback`, {
                    feedback_options: feedbackData.map(item => item.id)
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'Blog Feedback!',
                        message: data.success
                    })
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'Blog Feedback!',
                        message: data?.message
                    })
                    return false
                }
            } catch (e) {
                console.log(e)
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'Blog Feedback!',
                    message: error?.message
                })
                return false
            }
        },
        async fetchBlogFeedback(APP_API_URL, blogID) {
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}/feedback`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data) {
                    return data
                } else {
                    return null
                }
            } catch (e) {
                return null
            }
        },
        async storeFeedbackVote(APP_API_URL, blogID, label) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/blogs/${blogID}/feedback_vote`, {
                    answer: label
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'success',
                        title: 'Feedback vote!',
                        message: data.success
                    })
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        type: 'error',
                        title: 'Feedback vote!',
                        message: data.message
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'error',
                    title: 'Feedback vote!',
                    message: error.message
                })
                return false
            }
        },
        async getFeedbackVotes(APP_API_URL, blogID) {
            try {
                const response = await axios.get(`${APP_API_URL}/blogs/${blogID}/feedback_vote`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`
                    }
                })
                const data = response.data
                if (!data.error) {
                    return data
                } else {
                    return null
                }
            } catch (e) {
                console.error(e)
                return null
            }
        },
        async fetchAIModelsInfo(AI_API_URL) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(`${AI_API_URL}/info`)
                const data = response.data
                return Object.keys(data).length > 0 ? data : {}
            } catch (e) {
                notificationsStore.setPopupNotification({
                    open: true,
                    type: 'warning',
                    title: 'AI Model API!',
                    message: 'Cannot connect to AI API !'
                })
                return {}
            }
        },
        async fetchAIPredictions(AI_API_URL, modelUrlPath, image64) {
            try {
                const response = await axios.post(`${AI_API_URL}/${modelUrlPath}`, {
                    image64: image64
                })
                const data = response.data
                if (data) {
                    return data
                } else {
                    return null
                }
            } catch (e) {
                console.log(e)
                return null
            }
        }
    }
})
