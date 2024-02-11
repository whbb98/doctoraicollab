import {defineStore} from "pinia";

export const useNotificationsStore = defineStore('notificationsStore', {
    state: () => ({
        popupNotification: {
            open: false,
            title: '',
            message: '',
            type: ''
        },
        popupNotificationTimeout: 3000
    }),
    getters: {
        getPopupNotification() {
            return this.popupNotification
        },
        getPopupTimeout() {
            return this.popupNotificationTimeout
        }
    },
    actions: {
        initPopupNotification() {
            this.popupNotification.open = false
            this.popupNotification.title = ''
            this.popupNotification.message = ''
            this.popupNotification.type = ''
        },
        setPopupNotification(payload) {
            this.popupNotification.open = payload.open
            this.popupNotification.title = payload.title
            this.popupNotification.message = payload.message
            this.popupNotification.type = payload.type
            this.popupNotification.id = Math.random()
        }
    }
})
