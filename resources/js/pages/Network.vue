<template>
    <v-card>
        <template #loader>
            <v-progress-linear
                color="primary"
                v-if="isProfilesLoading"
                :indeterminate="isProfilesLoading"
            />
        </template>
        <v-card-title class="font-weight-bold text-capitalize text-primary">users network</v-card-title>
        <v-card-text>
            <v-form @submit.prevent="fetchSearchProfile" class="text-capitalize">
                <v-row align="center" justify="center">
                    <v-col cols="12">
                        <v-text-field
                            v-model="search.user"
                            label="type a username or email"
                            prepend-icon="mdi-account-search"
                            clearable
                        />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="6" md="3">
                        <v-select
                            v-model="search.city"
                            prepend-icon="mdi-city"
                            label="city"
                            :items="dz_cities"
                            item-value="value"
                            item-title="text"
                            chips
                            color="primary"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            v-model="search.hospital"
                            label="hospital"
                            prepend-icon="mdi-hospital-building"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            v-model="search.department"
                            label="department"
                            prepend-icon="mdi-domain"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            v-model="search.occupation"
                            label="occupation"
                            prepend-icon="mdi-doctor"
                            clearable
                        />
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-text>
            <v-card variant="flat">
                <v-card-title class="text-primary text-capitalize font-weight-bold mb-5">
                    <v-icon>mdi-text-search</v-icon>
                    search results:
                </v-card-title>
                <v-row>
                    <v-col v-for="profile in profiles">
                        <profile-card :profile="profile" :key="profile.user.id"/>
                    </v-col>
                </v-row>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script setup>

import ProfileCard from "@/components/ProfileCard.vue";
import {dz_cities} from "@/utils/constants.js";
import {inject, onMounted, reactive, ref, watch} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const ENV = inject('ENV')
const isProfilesLoading = ref(false)
const search = reactive({
    user: null,
    city: null,
    hospital: null,
    department: null,
    occupation: null
})
const users = [
    {
        username: 'ouahab98',
        name: 'abdelouahab radja',
        city: 'oran',
        hospital: 'CHO',
        department: 'pneumology',
        occupation: 'assistant',
        profileImgUrl: 'https://i.pravatar.cc/50',
        profileBackgroundUrl: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'
    }
]
const profileStore = useProfileStore()
const profiles = ref()

onMounted(async () => {
    await fetchSearchProfile()
})
watch(search, async () => {
    await fetchSearchProfile()
})

async function fetchSearchProfile() {
    isProfilesLoading.value = true
    profiles.value = await profileStore.fetchUserProfile(ENV.APP_API_URL, search)
    isProfilesLoading.value = false
}
</script>

<style scoped>

</style>
