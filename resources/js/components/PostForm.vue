<template>
    <v-form @submit.prevent="uploadPost" class="mb-5">
        <v-card rounded="51">
            <template #loader>
                <v-progress-linear
                    v-if="isPostLoading"
                    :indeterminate="isPostLoading"
                />
            </template>
            <v-card-title class="text-capitalize text-primary font-weight-bold">share new post</v-card-title>
            <v-card-text>
                <v-textarea v-model="post.description"
                            rows="3"
                            clearable
                            label="Post Description"
                            prepend-icon="mdi-text"
                />
                <v-file-input v-model="post.files"
                              multiple
                              clearable
                              chips
                              color="primary"
                              label="Post Attachments"
                />
                <v-switch v-model="post.visibility"
                          color="primary"
                          label="Visible to All"
                          prepend-icon="mdi-earth"
                />
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" variant="elevated" type="submit">
                    share
                    <v-icon>mdi-upload</v-icon>
                </v-btn>
                <v-btn color="warning" variant="outlined" type="reset">
                    clear
                    <v-icon>mdi-cancel</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script setup>
import {usePostsStore} from "@/stores/postsStore.js";
import {inject, reactive, ref} from "vue";

const ENV = inject('ENV')
const postsStore = usePostsStore()
const post = reactive({})
const isPostLoading = ref(false)

async function uploadPost() {
    isPostLoading.value = true
    await postsStore.createNewPost(ENV.APP_API_URL, post)
    isPostLoading.value = false
}
</script>

<style scoped>

</style>
