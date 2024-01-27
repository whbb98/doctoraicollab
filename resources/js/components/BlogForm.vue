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
                            <v-form @submit.prevent>
                                <v-row class="text-capitalize">
                                    <v-col cols="12" md="6">
                                        <v-col cols="12">
                                            <v-text-field name="title"
                                                          prepend-icon="mdi-text-account"
                                                          label="blog title"
                                                          variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea name="description"
                                                        prepend-icon="mdi-text"
                                                        label="blog description"
                                                        variant="outlined"
                                                        no-resize
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                prepend-icon="mdi-account-plus"
                                                v-model="participants"
                                                :items="people"
                                                chips
                                                closable-chips
                                                color="blue-grey-lighten-2"
                                                item-title="name"
                                                item-value="username"
                                                label="Add Participants (username, email) *"
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
                                                        :prepend-avatar="item.raw.avatar"
                                                        :title="item.raw.name"
                                                        :subtitle="item.raw.username"
                                                    ></v-list-item>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-col cols="12">
                                            <v-text-field prepend-icon="mdi-account-injury" name="patientID"
                                                          label="patient ID"/>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-checkbox-btn name="hasMeeting"
                                                            color="primary"
                                                            label="require a meeting ?"
                                                            v-model="isMeeting"
                                            />
                                        </v-col>
                                        <v-col cols="12" v-if="isMeeting">
                                            <date-form label="meeting date time"/>
                                            <v-text-field label="meeting link"
                                                          name="meetingUrl"
                                                          prepend-icon="mdi-link"
                                                          type="url"
                                                          placeholder="eg: https://meet.google.com/ysb-vnnz-iqc"
                                            />
                                            <v-text-field
                                                name="meetingDuration"
                                                label="duration (minutes)"
                                                prepend-icon="mdi-timer"
                                                type="number"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-file-input
                                                name="blogImages"
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
                                <v-btn type="submit" color="primary" rounded class="mr-2">Save</v-btn>
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

import {ref, watch} from "vue";
import DateForm from "@/components/DateForm.vue";

const dialogBlogForm = ref(false)
const isMeeting = ref(false)
const supportedFiles = [
    value => {
        return !value || !value.length || value[0].size < 5242880 || 'Image size should be less than 5 MB!'
    },
]
const participants = ref([])
watch(participants, newVal => {
    console.log(participants.value)
})
const people = [
    {
        username: 'ouahab98',
        name: 'Sandra Adams',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg'
    },
    {
        username: 'amine31',
        name: 'Ali Connors',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg'
    },
    {
        username: 'ahmed41',
        name: 'Trevor Hansen',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg'
    },
    {
        username: 'daddi17',
        name: 'Tucker Smith',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg'
    },
    {
        username: 'karim42',
        name: 'Britta Holt',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg'
    },
    {
        username: 'osmevercam',
        name: 'Jane Smith ',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg'
    },
    {
        username: 'moh31',
        name: 'John Smith',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg'
    },
    {
        username: 'meriem07',
        name: 'Sandra Williams',
        avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg'
    },
]
</script>

<style scoped>

</style>
