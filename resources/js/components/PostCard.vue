<template>
    <v-card class="mb-5">
        <template #loader>
            <v-progress-linear v-if="isDeleteLoading" :indeterminate="isDeleteLoading" color="warning"/>
        </template>
        <v-card-title>
            <v-avatar class="mr-2" color="secondary" size="50" :image="post.avatar">
                <span class="text-h5 text-uppercase">
                    {{ post.abbreviatedName }}
                </span>
            </v-avatar>
            <span class="text-capitalize">{{ post.userFullName }}</span>
            <v-btn class="delete-btn" variant="text" color="transparent" @click="handleDeletePost(post.id)">
                <v-icon size="30" color="error">mdi-delete-circle</v-icon>
            </v-btn>
        </v-card-title>
        <v-card-subtitle>On: {{ post.datetime }}</v-card-subtitle>
        <v-container class="d-flex" v-if="post.files.length > 0">
            <v-carousel show-arrows="hover">
                <v-carousel-item
                    v-for="file in post.files"
                    :src="file.base64"
                />
            </v-carousel>
        </v-container>
        <v-card-text>
            {{ post.description }}
        </v-card-text>
        <v-card-actions>
            <v-btn :color="true?'red':'primary'">
                <v-icon>mdi-heart</v-icon>
                {{ true ? 'Liked' : 'Like' }}
            </v-btn>
            <v-btn color="primary">
                <v-icon>mdi-share</v-icon>
                share
            </v-btn>
            <v-btn color="primary" :active="isCommentOpen" @click="isCommentOpen = !isCommentOpen">
                <v-icon>mdi-comment</v-icon>
                comments
            </v-btn>
        </v-card-actions>
        <v-card v-if="isCommentOpen">
            <v-container class="py-0">
                <v-form @submit.prevent="handlePostComment(post.id)" class="d-flex align-center">
                    <v-text-field :loading="isCommentLoading"
                                  v-model="postCommentText"
                                  @click:clear="postCommentID = null"
                                  clearable
                                  label="Your Comment"
                                  :prepend-icon="postCommentID?'mdi-tooltip-edit':'mdi-comment'"></v-text-field>
                </v-form>
            </v-container>
            <v-container class="comments">
                <user-comment-card v-for="comment in post.comments"
                                   :key="comment.id"
                                   :comment="comment"
                                   @update-comment="handleUpdateComment"
                                   @delete-comment="handleDeleteComment"
                />
            </v-container>
        </v-card>
    </v-card>
</template>

<script setup>
import {inject, ref} from "vue";
import UserCommentCard from "@/components/UserCommentCard.vue";
import {usePostsStore} from "@/stores/postsStore.js";

const props = defineProps(['post'])
const ENV = inject('ENV')
const isCommentOpen = ref(false)
const isDeleteLoading = ref(false)
const postsStore = usePostsStore()
const isCommentLoading = ref(false)
const postCommentText = ref('')
const postCommentID = ref(null)

async function handleDeletePost(id) {
    isDeleteLoading.value = true
    await postsStore.deletePost(ENV.APP_API_URL, id)
    isDeleteLoading.value = false
}

async function handlePostComment(postID) {
    if (postCommentText.value?.trim().length <= 0) {
        return
    }
    isCommentLoading.value = true
    await postsStore.handlePostComment(ENV.APP_API_URL, postID, postCommentID.value, postCommentText.value?.trim())
    postCommentText.value = ''
    postCommentID.value = null
    isCommentLoading.value = false
}

async function handleUpdateComment(id, text) {
    postCommentText.value = text
    postCommentID.value = id
}

async function handleDeleteComment(id) {
    console.log('deleting post comments will be added soon')
}

</script>

<style scoped>
.comments {
    max-height: 200px;
    overflow: auto;
}

.delete-btn {
    position: absolute;
    top: 0px;
    right: 0px;
}
</style>
