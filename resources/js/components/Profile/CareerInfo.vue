<template>
    <v-container>
        <v-card>
            <template #loader>
                <v-progress-linear
                    v-if="isCareerLoading"
                    :indeterminate="isCareerLoading"
                />
            </template>
            <v-card-title class="text-primary text-capitalize">career information</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="handleCareerUpdate">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-wallet-travel"
                                          class="text-capitalize"
                                          color="primary"
                                          label="occupation"
                                          :disabled="!editMode"
                                          v-model="profile.occupation"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-office-building"
                                          class="text-capitalize"
                                          color="primary"
                                          label="department"
                                          :disabled="!editMode"
                                          v-model="profile.department"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-hospital-building"
                                          class="text-capitalize"
                                          color="primary"
                                          label="hospital"
                                          :disabled="!editMode"
                                          v-model="profile.hospital"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-select prepend-icon="mdi-map-marker"
                                      class="text-capitalize"
                                      color="primary"
                                      label="city"
                                      :disabled="!editMode"
                                      v-model="profile.city"
                                      :items="dz_cities"
                                      item-title="text"
                                      item-value="value"
                            />
                        </v-col>
                    </v-row>
                    <v-btn type="submit"
                           class="mr-1"
                           color="primary">
                        <v-icon>mdi-content-save</v-icon>
                        save
                    </v-btn>
                    <v-btn color="primary" variant="outlined" @click="editMode=!editMode">
                        <v-icon>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import {inject, reactive, ref} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";
import {dz_cities} from "@/utils/constants.js";

const profileStore = useProfileStore()
const editMode = ref(false)
const profile = reactive({
    occupation: profileStore.getAuthUserProfile.profile.occupation,
    department: profileStore.getAuthUserProfile.profile.department,
    hospital: profileStore.getAuthUserProfile.profile.hospital,
    city: profileStore.getAuthUserProfile.profile.city
})
const isCareerLoading = ref(false)
const ENV = inject('ENV')

async function handleCareerUpdate() {
    isCareerLoading.value = true
    const status = await profileStore.updateProfileData(ENV.APP_API_URL, profile)
    isCareerLoading.value = false
}
</script>

<style scoped>

</style>
