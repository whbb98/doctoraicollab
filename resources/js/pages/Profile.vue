<template>
    <v-card>
        <template #loader>
            <v-progress-linear v-if="isProfileLoading" color="primary" :indeterminate="isProfileLoading"/>
        </template>
        <v-card-title class="text-capitalize">
            <v-avatar color="secondary" size="100" class="mr-5" :image="userProfile.avatar">
                <span class="text-h5 text-uppercase">{{ userProfile.abbreviatedName }}</span>
            </v-avatar>
            <span>{{
                    userProfile.firstName + ' ' + userProfile.lastName
                }}</span>
        </v-card-title>
        <v-card-text class="text-capitalize">
            <v-list bg-color="transparent">
                <v-list-item>
                    <div class="d-flex align-center">
                        <v-icon color="primary" class="mr-2">mdi-doctor</v-icon>
                        <span>{{ userProfile.profile.occupation }}</span>
                    </div>
                </v-list-item>
                <v-list-item>
                    <div class="d-flex align-center">
                        <v-icon color="primary" class="mr-2">mdi-hospital-building</v-icon>
                        <span>{{ userProfile.profile.hospital }}</span>
                    </div>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
    <v-card class="mt-1">
        <template #loader>
            <v-progress-linear v-if="isProfileLoading" color="primary" :indeterminate="isProfileLoading"/>
        </template>
        <v-tabs
            grow
            align-tabs="center"
            v-model="tab"
            bg-color="secondary">
            <v-tab value="overview" color="primary">
                <v-icon class="mr-1">mdi-account-box</v-icon>
                Overview
            </v-tab>
            <v-tab value="experience" color="primary">
                <v-icon class="mr-1">mdi-school</v-icon>
                Experience
            </v-tab>
            <v-tab value="contact" color="primary">
                <v-icon class="mr-1">mdi-card-account-mail</v-icon>
                Contact
            </v-tab>
            <v-tab value="settings" color="primary">
                <v-icon class="mr-1">mdi-cog</v-icon>
                Settings
            </v-tab>
        </v-tabs>
        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="overview">
                    <v-list>
                        <v-list-item>
                            <v-card>
                                <v-card-title class="text-capitalize text-primary">bio</v-card-title>
                                <v-card-text class="text-dark">
                                    {{ userProfile.profile.bio }}
                                </v-card-text>
                            </v-card>
                        </v-list-item>
                        <v-list-item>
                            <v-card>
                                <v-card-actions class="justify-space-between text-capitalize">
                                    <span class="d-flex align-center">
                                        <v-icon
                                            class="text-primary mr-1">mdi-map-marker</v-icon>
                                        {{ dz_cities[userProfile.profile.city] }}
                                    </span>
                                    <span class="d-flex align-center">
                                        <v-icon class="text-primary mr-1">mdi-domain</v-icon>
                                        {{ userProfile.profile.department }}
                                    </span>
                                    <span class="d-flex align-center">
                                        <v-icon
                                            class="text-primary mr-1">mdi-calendar-account</v-icon>
                                        {{ userProfile.joined }}
                                    </span>
                                </v-card-actions>
                            </v-card>
                        </v-list-item>
                        <!--                        <v-list-item>-->
                        <!--                            <span class="mr-5"><b>15</b> following</span>-->
                        <!--                            <span><b>30</b> followers</span>-->
                        <!--                        </v-list-item>-->
                        <v-list-item>
                            <v-card>
                                <v-card-title class="text-primary">Followers Network</v-card-title>
                                <v-row>
                                    <profile-card v-for="user in users" :user="user"/>
                                </v-row>
                            </v-card>
                        </v-list-item>
                    </v-list>
                </v-window-item>

                <v-window-item value="experience">
                    <ExperienceForm :selected-career="selectedCareer"/>
                    <ExperienceData @select-row="handleSelectedCareer"/>
                </v-window-item>

                <v-window-item value="contact">
                    <contact-me-form/>
                    <contact-me/>
                </v-window-item>

                <v-window-item value="settings">
                    <personal-info/>
                    <career-info/>
                    <notifications-settings/>
                    <account-settings/>
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {computed, inject, ref} from "vue";
import ProfileCard from "@/components/ProfileCard.vue";
import ExperienceForm from "@/components/ExperienceForm.vue";
import ExperienceData from "@/components/ExperienceData.vue";
import ContactMe from "@/components/ContactMe.vue";
import ContactMeForm from "@/components/ContactMeForm.vue";
import PersonalInfo from "@/components/Profile/PersonalInfo.vue";
import CareerInfo from "@/components/Profile/CareerInfo.vue";
import NotificationsSettings from "@/components/Profile/NotificationsSettings.vue";
import AccountSettings from "@/components/Profile/AccountSettings.vue";
import {useProfileStore} from "@/stores/profileStore.js";
import {dz_cities} from "@/utils/constants.js";

const ENV = inject('ENV')
const tab = ref(null)
const profileStore = useProfileStore()
const isProfileLoading = ref(false)
const userProfile = computed(() => {
    return profileStore.getAuthUserProfile
})
const selectedCareer = ref(null)

function handleSelectedCareer(career) {
    selectedCareer.value = career
}

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
</script>

<style scoped>

</style>
