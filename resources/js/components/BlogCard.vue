<template>
    <v-card color="secondary">
        <v-card-title class="pa-0">
            <v-img height="200" cover :src="blog.backgroundUrl">
                <template #placeholder>
                    <div class="d-flex align-center justify-center fill-height">
                        <v-progress-circular
                            color="primary"
                            indeterminate
                        ></v-progress-circular>
                    </div>
                </template>
            </v-img>
        </v-card-title>
        <v-card-text class="text-capitalize mt-3 py-0">
            <h3 class="mb-2">{{blog.title}}</h3>
            <p class="mb-3">
                {{ truncatedDescription }}
            </p>
            <span class="d-flex align-center">
                <v-icon>mdi-calendar</v-icon>
                {{blog.createdAt}}
            </span>
        </v-card-text>
        <v-card-actions>
            <span class="d-flex align-center mr-5">
                <v-icon>mdi-account-group</v-icon>
                {{blog.participants}}
            </span>
            <span class="d-flex align-center">
                <v-icon>mdi-comment-multiple-outline</v-icon>
                {{blog.comments}}
            </span>
            <v-spacer/>
            <router-link :to="`/blogs/${blog.id}`" class="text-capitalize text-decoration-none text-primary">read more
            </router-link>
        </v-card-actions>
    </v-card>
</template>

<script setup>

import {computed} from "vue";

const props = defineProps(['blog'])
const maxLength = 100
const truncatedDescription = computed(() => {
    if (props.blog.description.length <= maxLength) {
        return props.blog.description
    } else {
        return props.blog.description.slice(0, maxLength) + '...'
    }
})
</script>

<style scoped>

</style>
