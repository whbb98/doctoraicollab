import {defineStore} from "pinia";
import {useProfileStore} from "@/stores/profileStore.js";

export const useMainStore = defineStore('mainStore', {
    state: () => ({}),
    getters: {},
    actions: {
        async initStores(APP_API_URL) {
        }
    }
})
