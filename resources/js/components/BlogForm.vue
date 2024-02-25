<template>
    <v-btn rounded color="primary">
        new blog
        <v-dialog
            persistent
            transition="dialog-bottom-transition"
            v-model="dialogBlogForm"
            activator="parent">
            <v-container>
                <v-card max-height="90vh" class="overflow-y-auto">
                    <v-card-title class="text-capitalize text-primary">
                        create new blog
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-form @submit.prevent="createBlogHandler">
                                <v-row class="text-capitalize">
                                    <v-col cols="12" md="6">
                                        <v-col cols="12">
                                            <v-text-field v-model.trim="blogForm.title"
                                                          prepend-icon="mdi-text-account"
                                                          label="blog title"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea v-model.trim="blogForm.description"
                                                        prepend-icon="mdi-text"
                                                        label="blog description"
                                                        no-resize
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                class="text-capitalize"
                                                @update:search="fetchParticipant"
                                                prepend-icon="mdi-account-plus"
                                                v-model="blogForm.participants"
                                                :items="people"
                                                chips
                                                closable-chips
                                                color="blue-grey-lighten-2"
                                                item-title="name"
                                                item-value="username"
                                                label="Add Participants *"
                                                multiple
                                            >
                                                <template v-slot:chip="{ props, item }">
                                                    <v-chip
                                                        v-bind="props"
                                                        :prepend-avatar="item.raw.avatar"
                                                        :text="item.raw.name"
                                                    ></v-chip>
                                                </template>

                                                <template v-slot:item="{ props, item }">
                                                    <v-list-item
                                                        v-bind="props"
                                                        :title="item.raw.name"
                                                        :subtitle="item.raw.username"
                                                    >
                                                        <template #prepend>
                                                            <v-avatar color="secondary"
                                                                      class="mr-5" size="40"
                                                                      :image="item.raw.avatar">
                                                                <span class="text-h5 text-uppercase">
                                                                    {{ item.raw.abbreviatedName }}
                                                                </span>
                                                            </v-avatar>
                                                        </template>
                                                    </v-list-item>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-col cols="12" v-if="false">
                                            <v-text-field prepend-icon="mdi-account-injury"
                                                          v-model="blogForm.patientID"
                                                          label="patient ID"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-checkbox-btn
                                                color="primary"
                                                label="require a meeting ?"
                                                v-model="blogForm.hasMeeting"
                                            />
                                        </v-col>
                                        <v-col cols="12" v-if="blogForm.hasMeeting">
                                            <v-text-field v-model="blogForm.meetingDatetime"
                                                          prepend-icon="mdi-calendar"
                                                          type="datetime-local"/>
                                            <v-text-field label="meeting link"
                                                          v-model="blogForm.meetingLink"
                                                          prepend-icon="mdi-link"
                                                          type="url"
                                                          placeholder="eg: https://meet.google.com/ysb-vnnz-iqc"
                                            />
                                            <v-text-field
                                                v-model="blogForm.meetingDuration"
                                                label="duration (minutes)"
                                                prepend-icon="mdi-timer"
                                                type="number"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-file-input
                                                v-model="blogForm.files"
                                                prepend-icon="mdi-radiology-box-outline"
                                                label="X-RAY Images"
                                                accept="image/png, image/jpeg, image/bmp"
                                                :rules="supportedFiles"
                                                multiple
                                                chips
                                                color="primary"
                                            />
                                        </v-col>
                                    </v-col>
                                </v-row>
                                <v-btn :loading="isBlogLoading" type="submit" color="primary" rounded class="mr-2">
                                    Save
                                </v-btn>
                                <v-btn color="warning" rounded variant="outlined" @click="dialogBlogForm = false">
                                    Cancel
                                </v-btn>
                            </v-form>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-dialog>
    </v-btn>
</template>

<script setup>

import {inject, reactive, ref, watch} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";
import {useBlogsStore} from "@/stores/blogsStore.js";
import {useAuthStore} from "@/stores/authStore.js";

const profileStore = useProfileStore()
const ENV = inject('ENV')
const dialogBlogForm = ref(false)
const supportedFiles = [
    value => {
        return !value || !value.length || value[0].size < 5242880 || 'Image size should be less than 5 MB!'
    },
]
const people = reactive([])
const blogForm = reactive({})
const isBlogLoading = ref(false)
const blogsStore = useBlogsStore()

async function fetchParticipant(search) {
    const data = await (profileStore.fetchUserProfile(ENV.APP_API_URL, {user: search}))
    data.map(item => {
        const user = item.user
        const status = people.find(item => item.username === user.username)
        if (!status) {
            people.push({
                username: user.username,
                name: user.firstName + ' ' + user.lastName,
                abbreviatedName: user.firstName.charAt(0) + user.lastName.charAt(0),
                avatar: user.avatar
            })
        }
    })
    const idx = people.findIndex(user => user.username === useAuthStore().getUser.username)
    people.splice(idx, 1)
}

async function createBlogHandler() {
    isBlogLoading.value = true
    const status = await blogsStore.createNewBlog(ENV.APP_API_URL, blogForm)
    if (status) {
        for (let key in blogForm) {
            blogForm[key] = null
        }
        dialogBlogForm.value = false
    }
    isBlogLoading.value = false
}
</script>

<style scoped>

</style>
