<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">personal information</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form>
                        <v-row>
                            <v-col cols="12">
                                <PictureUpdateForm photo>
                                    <template #heading>
                                        upload your personal photo
                                    </template>
                                    <template #uploadDescription>
                                        make sure that photo is personal and your face is clear
                                    </template>
                                </PictureUpdateForm>
                            </v-col>
                            <v-col cols="12">
                                <PictureUpdateForm cover>
                                    <template #heading>
                                        upload a cover picture
                                    </template>
                                </PictureUpdateForm>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea color="primary"
                                            class="text-capitalize"
                                            label="about"
                                            :disabled="!profileEditMode"
                                            v-model="user.profile.bio"
                                />
                            </v-col>
                        </v-row>
                        <v-btn class="mr-1"
                               color="primary"
                               @click="saveProfileHandler"
                               :loading="isProfileLoading"
                        >
                            <v-icon>mdi-content-save</v-icon>
                            save
                        </v-btn>
                        <v-btn color="primary" variant="outlined" @click="profileEditMode=!profileEditMode">
                            <v-icon>mdi-square-edit-outline</v-icon>
                            edit
                        </v-btn>
                    </v-form>
                </v-container>
                <v-container>
                    <v-form>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary"
                                              class="text-capitalize"
                                              label="first name"
                                              :disabled="!userEditMode"
                                              v-model="user.firstName"
                                />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary"
                                              class="text-capitalize"
                                              label="last name"
                                              :disabled="!userEditMode"
                                              v-model="user.lastName"
                                />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary"
                                              class="text-capitalize"
                                              label="email address"
                                              :disabled="!userEditMode"
                                              v-model="user.email"
                                />
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary"
                                              class="text-capitalize"
                                              label="phone N°"
                                              :disabled="!userEditMode"
                                              v-model="user.phone"
                                />
                            </v-col>
                        </v-row>
                        <v-btn class="mr-1"
                               color="primary"
                               @click="saveUserHandler"
                               :loading="isUserLoading"
                        >
                            <v-icon>mdi-content-save</v-icon>
                            save
                        </v-btn>
                        <v-btn color="primary" variant="outlined" @click="userEditMode=!userEditMode">
                            <v-icon>mdi-square-edit-outline</v-icon>
                            edit
                        </v-btn>
                    </v-form>
                </v-container>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import PictureUpdateForm from "@/components/Profile/PictureUpdateForm.vue";
import {inject, reactive, ref} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const userEditMode = ref(false)
const profileEditMode = ref(false)
const isProfileLoading = ref(false)
const isUserLoading = ref(false)
const profileStore = useProfileStore()
const user = reactive({...profileStore.getAuthUserProfile})
const ENV = inject('ENV')


async function saveProfileHandler() {
    isProfileLoading.value = true
    const currentData = profileStore.getAuthUserProfile
    const status = await profileStore.updateProfileData(ENV.APP_API_URL, {
        bio: (user.profile.bio === currentData.profile.bio) ? undefined : user.profile.bio
    })
    isProfileLoading.value = false
}

async function saveUserHandler() {
    const currentData = profileStore.getAuthUserProfile
    isUserLoading.value = true
    const status = await profileStore.updateUserData(ENV.APP_API_URL, {
        first_name: (user.firstName === currentData.firstName) ? undefined : user.firstName,
        last_name: (user.lastName === currentData.lastName) ? undefined : user.lastName,
        email: (user.email === currentData.email) ? undefined : user.email,
        phone: (user.phone === currentData.phone) ? undefined : user.phone
    })
    isUserLoading.value = false
}
</script>

<style scoped>

</style>
