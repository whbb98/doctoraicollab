import {defineStore} from "pinia";
import axios from "axios";
import {useAuthStore} from "@/stores/authStore.js";
import {useNotificationsStore} from "@/stores/notificationsStore.js";

export const useProfileStore = defineStore('profileStore', {
    state: () => ({
        authUserProfile: null
    }),
    getters: {
        getAuthUserProfile() {
            return this.authUserProfile
        }
    },
    actions: {
        async fetchAuthUserProfile(APP_API_URL) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.get(
                    `${APP_API_URL}/users/${useAuthStore().getUser.username}`,
                    {
                        headers: {
                            Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                        }
                    })
                const data = response.data
                this.authUserProfile = data.data
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    title: 'loading profile data',
                    message: error.message ?? 'Error while loading profile data',
                    type: 'error'
                })
            }
        },
        async createNewCareer(APP_API_URL, careerObj) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/careers`, {
                    ...careerObj,
                    career_name: careerObj.name
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                    }
                })
                const data = response.data
                if (!data.error) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'adding new experience record',
                        message: 'new experience added successfully!',
                        type: 'success'
                    })
                    this.authUserProfile.career.unshift(data.data)
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'adding new experience record',
                        message: 'Error while adding data',
                        type: 'error'
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    title: 'adding new experience record',
                    message: error.message ?? 'Error while adding data',
                    type: 'error'
                })
            }
        },
        async updateCareer(APP_API_URL, careerObj) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.patch(`${APP_API_URL}/careers/${careerObj.id}`, {
                    ...careerObj,
                    career_name: careerObj.name
                }, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                    }
                })
                const data = response.data
                if (!data.error) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'updating experience',
                        message: 'experience data updated successfully!',
                        type: 'success'
                    })
                    const careerItem = this.authUserProfile.career.find(item => item.id === careerObj.id)
                    careerItem.type = careerObj.type
                    careerItem.career_name = careerObj.name
                    careerItem.period = careerObj.period
                    careerItem.organization = careerObj.organization
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'updating experience record',
                        message: 'Error while updating data',
                        type: 'error'
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    title: 'updating experience record',
                    message: error.message ?? 'Error while updating your data',
                    type: 'error'
                })
            }
        },
        async deleteCareer(APP_API_URL, id) {
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.delete(`${APP_API_URL}/careers/${id}`, {
                    headers: {
                        Authorization: `Bearer ${useAuthStore().getAuthToken}`,
                    }
                })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'delete experience',
                        message: 'experience data deleted successfully!',
                        type: 'success'
                    })
                    const itemIndex = this.authUserProfile.career.findIndex(item => item.id === id)
                    this.authUserProfile.career.splice(itemIndex, 1)
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'delete experience record',
                        message: 'Error while deleting data',
                        type: 'error'
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    title: 'delete experience record',
                    message: error.message ?? 'Error while deleting your data',
                    type: 'error'
                })
            }
        },
        async updateContactInfo(APP_API_URL, contact) {
            const profileStore = useProfileStore()
            const notificationsStore = useNotificationsStore()
            try {
                const response = await axios.post(`${APP_API_URL}/contacts`,
                    contact,
                    {
                        headers: {
                            Authorization: `Bearer ${useAuthStore().getAuthToken}`
                        }
                    })
                const data = response.data
                if (data.success) {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'contact update',
                        message: 'contacts record updated successfully!',
                        type: 'success'
                    })
                    profileStore.authUserProfile.contact = contact
                    return true
                } else {
                    notificationsStore.setPopupNotification({
                        open: true,
                        title: 'contact update',
                        message: data.message,
                        type: 'error'
                    })
                    return false
                }
            } catch (e) {
                const error = e.response.data
                notificationsStore.setPopupNotification({
                    open: true,
                    title: 'contact update',
                    message: error.message,
                    type: 'error'
                })
            }
        }
    }
})
