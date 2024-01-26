<template>
    <v-card class="pa-2 d-flex justify-space-between align-center"
            :color="notification.isRead?'secondary':'primary'">
        <v-avatar class="profile-avatar" color="secondary" size="75" image="https://i.pravatar.cc/50">
            <span class="text-h5">AR</span>
        </v-avatar>
        <div class="ml-5 w-100">
            <p class="notification-body text-h6">
                <b>{{ notification.sender }}</b> {{ notification.message }}
            </p>
            <div class="notification-footer mt-5 d-flex justify-space-between">
                <span :class="notification.isRead?'text-primary':'text-white'">
                    {{ notification.createdAt }}
                </span>
                <span v-if="!notification.isRead"
                      class="font-weight-bold text-dark"
                      @click="markAsRead(notification.id)">
                    <v-icon title="mark as read">mdi-playlist-check</v-icon>
                </span>
            </div>
        </div>
    </v-card>
</template>

<script setup>
const emit = defineEmits(['markAsRead'])
const props = defineProps(['notification'])

function markAsRead(id) {
    emit('markAsRead', id)
}
</script>

<style scoped>
.notification-footer span:last-of-type {
    cursor: pointer;
}
</style>
