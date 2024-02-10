<template>
    <PostForm @open-snackbar="openSnackBar"/>
    <v-alert
        v-if="postsStore.getPosts.length <= 0"
        type="info"
        class="mb-5"
        color="secondary"
    >
        <template #title>
            <p class="text-capitalize">no posts available !</p>
        </template>
    </v-alert>
    <v-alert
        v-if="isPostsLoading"
        title="Loading Posts..."
        color="primary">
        <template #prepend>
            <v-progress-circular :indeterminate="isPostsLoading"/>
        </template>
    </v-alert>
    <PostCard @open-snackbar="openSnackBar" v-for="post in posts" :post="post"/>
</template>

<script setup>

import PostForm from "@/components/PostForm.vue";
import PostCard from "@/components/PostCard.vue";
import {usePostsStore} from "@/stores/postsStore.js";
import {computed, inject, onMounted, ref} from "vue";

const ENV = inject('ENV')
const emit = defineEmits(['openSnackbar'])
const postsStore = usePostsStore()
const isPostsLoading = ref(false)
const posts = computed(() => {
    return postsStore.getPosts.data
})

function openSnackBar(payload) {
    emit('openSnackbar', payload)
}

onMounted(async () => {
    isPostsLoading.value = true
    await postsStore.fetchPosts(ENV.APP_API_URL)
    isPostsLoading.value = false
})

</script>

<style scoped>

</style>
