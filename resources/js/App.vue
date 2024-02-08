<template>
    <v-app>
        <router-view @open-snackbar="openSnackbarPopup"/>
        <v-footer order="0" app color="dark">
            <h1>footer</h1>
        </v-footer>
        <popup-snackbar :data="popupData"/>
    </v-app>
</template>

<script setup>
import {provide, ref} from "vue";
import PopupSnackbar from "@/components/PopupSnackbar.vue";

const ENV = {
    APP_URL: import.meta.env.VITE_APP_URL,
    APP_API_URL: import.meta.env.VITE_APP_API_URL,
    getCsrfToken: getCsrfToken()
}
provide('ENV', ENV)

const popupData = ref({
    open: false,
    title: '',
    message: '',
    type: ''
});

function openSnackbarPopup(data) {
    if (data) {
        popupData.value = data
    }
}

function getCsrfToken() {
    return document.head.querySelector('meta[name="csrf-token"]').content;
}
</script>


<style>

</style>
