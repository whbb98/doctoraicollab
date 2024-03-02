<template>
    <v-card-text>
        <v-card-title>
            <v-avatar class="mr-2" color="secondary" size="50" :image="comment?.user.avatar">
                <span class="text-h5 text-uppercase">{{ comment.user.abbreviatedName }}</span>
            </v-avatar>
            <span class="text-capitalize">
                {{ comment.user.firstName + ' ' +comment.user.lastName }}
            </span>
        </v-card-title>
        <v-card-subtitle>{{ comment.datetime }}</v-card-subtitle>
        <v-card-text>
            {{ comment.comment }}
            <v-btn v-if="comment.user.username === authStore?.getUser?.username"
                   class="mr-1"
                   icon="mdi-pencil-outline"
                   color="primary"
                   size="30"
                   @click="updateComment(comment.id,comment.comment)"/>
            <v-btn v-if="comment.user.username === authStore?.getUser?.username"
                   icon="mdi-delete"
                   color="error"
                   size="30"
                   @click="deleteComment(comment.id)"/>
        </v-card-text>
    </v-card-text>
</template>

<script setup>
import {useAuthStore} from "@/stores/authStore.js";

const authStore = useAuthStore()
const props = defineProps(['comment'])
const emit = defineEmits(['updateComment', 'deleteComment'])

function updateComment(id, text) {
    emit('updateComment', id, text)
}

function deleteComment(id) {
    emit('deleteComment', id)
}

</script>

<style scoped>

</style>
