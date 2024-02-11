<template>
    <v-app>
        <router-view/>
        <v-footer order="0" app color="dark">
            <h1>footer</h1>
        </v-footer>
        <popup-snackbar :data="popupData"/>
    </v-app>
</template>

<script setup>
import {computed, provide, reactive, ref, watch, watchEffect} from "vue";
import PopupSnackbar from "@/components/PopupSnackbar.vue";
import {useNotificationsStore} from "@/stores/notificationsStore.js";

const ENV = {
    APP_URL: import.meta.env.VITE_APP_URL,
    APP_API_URL: import.meta.env.VITE_APP_API_URL,
    getCsrfToken: getCsrfToken()
}
provide('ENV', ENV)
const notificationsStore = useNotificationsStore()
const popupData = reactive({
    open: false,
    title: '',
    message: '',
    type: ''
})

watch(notificationsStore.getPopupNotification, (newVal) => {
    popupData.id = newVal.id
    popupData.open = newVal.open
    popupData.title = newVal.title
    popupData.message = newVal.message
    popupData.type = newVal.type
})

function getCsrfToken() {
    return document.head.querySelector('meta[name="csrf-token"]').content;
}
</script>


<style>

</style>
