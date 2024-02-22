<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">
                notifications settings
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <v-checkbox v-for="(item,key) in notificationSettings"
                                        v-model="notificationSettings[key]"
                                        :key="key"
                                        :label="notificationsList.find(item=>item.name===key).description"
                                        :readonly="!editMode"
                                        color="primary"
                                        class="text-capitalize text-high-emphasis"
                            />
                        </v-col>
                    </v-row>
                    <v-btn v-if="editMode"
                           class="mr-1"
                           color="primary"
                           @click="updateNotificationSettings"
                    >
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
import {inject, onMounted, reactive, ref, watch} from "vue";
import {notificationsList} from "@/utils/constants.js";
import {useProfileStore} from "@/stores/profileStore.js";

const profileStore = useProfileStore()
const editMode = ref(false)
const isLoading = ref(false)
const ENV = inject('ENV')
const notificationSettings = reactive(profileStore.getAuthUserProfile.notificationSettings)

async function updateNotificationSettings() {
    isLoading.value = true
    const status = await profileStore.updateProfileNotificationSettings(ENV.APP_API_URL, notificationSettings)
    if (!status) {
        Object.assign(notificationSettings, {...profileStore.getAuthUserProfile.notificationSettings})
    }
    isLoading.value = false
}
</script>

<style scoped>

</style>
