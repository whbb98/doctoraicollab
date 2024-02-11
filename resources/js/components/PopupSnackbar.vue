<template>
    <v-snackbar :timeout="notificationsStore.getPopupTimeout" v-model="isPopupOpened" :color="popupColor" location="top">
        <div class="text-capitalize font-weight-bold text-subtitle-1 pb-2">
            {{popupTitle}}
        </div>
        <p v-if="popupMessage" class="text-capitalize">{{popupMessage}}</p>
        <template #actions>
            <v-btn @click="isPopupOpened = false">
                <v-icon>mdi-close-circle</v-icon>
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import {ref, watch} from "vue";
import {useNotificationsStore} from "@/stores/notificationsStore.js";

const props = defineProps(['data'])
const isPopupOpened = ref(null)
const popupColor = ref(null)
const popupTitle = ref(null)
const popupMessage = ref(null)
const notificationsStore = useNotificationsStore()
const colors = {
    success: 'primary',
    error: 'error',
    info: 'secondary',
    warning: 'warning'
}

watch(notificationsStore.getPopupNotification, (newVal) => {
    isPopupOpened.value = newVal.open
    popupTitle.value = newVal.title
    popupMessage.value = newVal.message
    popupColor.value = colors[newVal.type]
    console.log(newVal)
})

</script>

<style scoped>

</style>
