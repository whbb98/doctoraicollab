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
            <v-container>
                <v-form @submit.prevent class="d-flex align-center">
                    <v-text-field name="comment" clearable label="Your Comment"
                                  prepend-icon="mdi-comment"></v-text-field>
                </v-form>
            </v-container>
            <v-container class="comments">
                <user-comment-card v-for="item in userComments" :userComment="item"/>
            </v-container>
        </v-card>
    </v-card>
</template>

<script setup>
import {inject, ref} from "vue";
import UserCommentCard from "@/components/UserCommentCard.vue";
import {usePostsStore} from "@/stores/postsStore.js";

const emit = defineEmits('openSnackbar')
const props = defineProps(['post'])
const ENV = inject('ENV')
const isCommentOpen = ref(false)
const isDeleteLoading = ref(false)
const postsStore = usePostsStore()

async function handleDeletePost(id) {
    isDeleteLoading.value = true
    const deleteStatus = await postsStore.deletePost(ENV.APP_API_URL, id)
    emit('openSnackbar', deleteStatus)
    isDeleteLoading.value = false
}

const userComments = [
    {
        id: 1,
        nameAbbr: 'AR',
        fullName: 'abdelouahab radja',
        avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 2,
        nameAbbr: 'AS',
        fullName: 'amine smahi',
        avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 3,
        nameAbbr: 'ob',
        fullName: 'oussama bonnor',
        // avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    }
]
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
