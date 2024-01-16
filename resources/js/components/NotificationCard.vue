<template>
    <v-card class="pa-2 d-flex justify-space-between align-center" color="secondary">
        <v-avatar class="profile-avatar" color="secondary" size="75" image="https://i.pravatar.cc/50">
            <span class="text-h5">AR</span>
        </v-avatar>
        <div class="ml-5 w-100">
            <p class="notification-body text-h6">
                <b>{{notification.sender}}</b>
                {{ notification.message }}
            </p>
            <div class="notification-footer mt-5 d-flex justify-space-between">
                <span class="text-primary">{{ notification.createdAt }}</span>
                <span v-if="!notification.isRead" class="text-primary font-weight-bold"
                @click="notification.isRead = true"
                >mark as read</span>
            </div>
        </div>
    </v-card>
</template>

<script setup>
import {reactive} from "vue";

const notification = reactive({
    id: '545',
    sender: 'John Doe',
    message: 'praesent impetus vestibulum porro quaestio no appareat pharetra.',
    isRead: false,
    createdAt: '16 Jan 2024 at 14:32'
})

</script>

<style scoped>
.notification-footer span:last-of-type{
    cursor: pointer;
}
</style>
