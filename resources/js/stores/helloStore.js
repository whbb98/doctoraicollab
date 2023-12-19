import {defineStore} from "pinia";

export const useHelloStore = defineStore(
    'helloStore', {
        state: () => ({
            name: 'habhoob radja'
        }),
        getters: {},
        actions: {}
    }
)
