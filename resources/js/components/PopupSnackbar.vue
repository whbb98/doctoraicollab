<template>
    <v-snackbar v-model="isPopupOpened" :color="popupColor">
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

const props = defineProps(['data'])
const isPopupOpened = ref(null)
const popupColor = ref(null)
const popupTitle = ref(null)
const popupMessage = ref(null)
const colors = {
    success: 'primary',
    error: 'error',
    info: 'secondary',
    warning: 'warning'
}
watch(() => props.data, (newData) => {
    isPopupOpened.value = newData.open
    popupTitle.value = newData.title
    popupMessage.value = newData.message
    popupColor.value = colors[newData.type]
})

</script>

<style scoped>

</style>
