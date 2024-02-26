<template>
    <v-card color="secondary">
        <v-card-title class="pa-0">
            <v-img height="200" cover :src="blog.cover">
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
            <h3 class="mb-2">{{ blog.title }}</h3>
            <span class="d-flex align-center">
                <v-icon class="mr-1">mdi-calendar</v-icon>
                {{ meetingDate }}
            </span>
        </v-card-text>
        <v-card-actions>
            <span class="d-flex align-baseline mr-5">
                <v-icon class="mr-1">mdi-account-group</v-icon>
                {{ blog.participants }}
            </span>
            <v-spacer/>
            <v-btn color="primary" variant="outlined">
                <a :href="blog.meeting.link" target="_blank" class="text-capitalize text-decoration-none text-primary">
                    join meeting
                </a>
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>

import {computed} from "vue";

const props = defineProps(['blog'])
const meetingDate = computed(() => {
    const date = new Date(props.blog.meeting.scheduled)
    return `${date.toDateString()} ${date.getHours()}:${date.getMinutes()}`
})
</script>

<style scoped>

</style>
