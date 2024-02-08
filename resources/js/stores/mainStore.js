import {defineStore} from "pinia";
import axios from "axios";

export const useMainStore = defineStore('mainStore', {
    state: () => ({
        authUser: null,
        token: null,
    }),
    getters: {
        getAuthToken() {
            return this.token
        },
        getAuthUser() {
            return this.authUser
        },
        getUserNameAbbr() {
            return this.getAuthUser.firstName.charAt(0) + this.getAuthUser.lastName.charAt(0)
        }
    },
    actions: {
        async login(user, pass, APP_API_URL) {
            try {
                const response = await axios.post(`${APP_API_URL}/login`, {
                    username: user,
                    password: pass
                })
                const data = response.data
                if (data.error) {
                    return {
                        open: true,
                        type: 'error',
                        title: 'login failed !',
                        message: data.error
                    }
                } else {
                    this.token = data.auth_token
                    this.authUser = data.auth_user
                    return {
                        open: true,
                        type: 'success',
                        title: 'login success',
                        message: `welcome ${data.auth_user.firstName}`
                    }
                }
            } catch (e) {
                const error = e.response.data
                return {
                    open: true,
                    type: 'error',
                    title: 'login failed !',
                    message: error.message
                }
            }
        },
        async logout(APP_API_URL) {
            try {
                const response = await axios.post(`${APP_API_URL}/logout`, {}, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    },
                })
                const data = response.data
                if (data.error) {
                    return {
                        open: true,
                        type: 'warning',
                        title: 'logout failed !',
                        message: data.error
                    }
                } else {
                    this.authUser = null
                    this.token = null
                    this.$router.push('/login')
                    return {
                        open: true,
                        type: 'success',
                        title: 'logout success !',
                        message: data.message
                    }
                }
            } catch (e) {
                const error = e.response.data
                this.authUser = null
                this.token = null
                this.$router.push('/login')
                return {
                    open: true,
                    type: 'error',
                    title: 'logout failed !',
                    message: error.message
                }
            }
        }
    }
})
