<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">
                account settings
            </v-card-title>
            <v-card-text>
                <v-form @submit.prevent="updateEmail">
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            email update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field readonly class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-email"
                                          label="current email"
                                          :model-value="authUser.email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-email"
                                          label="new email"
                                          v-model="account.email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          label="password"
                                          :type="account.emailPassVisible?'text':'password'"
                                          v-model="account.emailPassword"
                            >
                                <template #append-inner>
                                    <v-icon @click="account.emailPassVisible=!account.emailPassVisible">
                                        {{ account.emailPassVisible ? 'mdi-eye' : 'mdi-eye-off' }}
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-btn v-if="editMode.email"
                           class="mr-5"
                           color="primary"
                           :loading="isEmailLoading"
                           type="submit"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                    <v-btn color="primary"
                           variant="outlined"
                           @click="editMode.email=!editMode.email"
                    >
                        <v-icon>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>
                </v-form>
            </v-card-text>
            <v-card-text>
                <v-form @submit.prevent="updatePhone">
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            phone Number update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field readonly class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-phone"
                                          label="current phone number"
                                          :model-value="authUser.phone"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-phone"
                                          label="new phone number"
                                          v-model="account.phone"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          label="password"
                                          :type="account.phonePassVisible?'text':'password'"
                                          v-model="account.phonePassword"
                            >
                                <template #append-inner>
                                    <v-icon @click="account.phonePassVisible=!account.phonePassVisible">
                                        {{ account.phonePassVisible ? 'mdi-eye' : 'mdi-eye-off' }}
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-btn v-if="editMode.phone"
                           class="mr-5"
                           color="primary"
                           :loading="isPhoneLoading"
                           type="submit"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                    <v-btn color="primary"
                           variant="outlined"
                           @click="editMode.phone=!editMode.phone"
                    >
                        <v-icon>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>
                </v-form>
            </v-card-text>
            <v-card-text>
                <v-form @submit.prevent="updatePassword">
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            password update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          label="current password"
                                          type="password"
                                          v-model="account.passwordOld"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          label="new password"
                                          :type="account.passwordNewVisible?'text':'password'"
                                          v-model="account.passwordNew"
                            >
                                <template #append-inner>
                                    <v-icon @click="account.passwordNewVisible=!account.passwordNewVisible">
                                        {{ account.passwordNewVisible ? 'mdi-eye' : 'mdi-eye-off' }}
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          label="confirm new password"
                                          type="password"
                                          v-model="account.passwordConfirm"
                                          :rules="[validatePassword]"
                            />
                        </v-col>
                    </v-row>
                    <v-btn v-if="editMode.password"
                           class="mr-5"
                           color="primary"
                           :loading="isPasswordLoading"
                           type="submit"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                    <v-btn color="primary"
                           variant="outlined"
                           @click="editMode.password=!editMode.password"
                    >
                        <v-icon>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import {validateDigits} from "@/utils/validateRules.js";
import {computed, inject, reactive, ref} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const ENV = inject('ENV')
const isEmailLoading = ref(false)
const isPasswordLoading = ref(false)
const isPhoneLoading = ref(false)
const profileStore = useProfileStore()
const authUser = computed(() => {
    return profileStore.getAuthUserProfile
})
const account = reactive({})
const editMode = reactive({
    email: false,
    phone: false,
    password: false
})

function validatePassword(val) {
    return account.passwordNew === account.passwordConfirm || 'Password does not much'
}

async function updateEmail() {
    isEmailLoading.value = true
    const status = await profileStore.updateUserData(ENV.APP_API_URL, {
        email: account.email,
        old_password: account.emailPassword
    })
    if (status) {
        account.email = ''
        account.emailPassword = ''
    }
    isEmailLoading.value = false
}

async function updatePhone() {
    isPhoneLoading.value = true
    const status = await profileStore.updateUserData(ENV.APP_API_URL, {
        phone: account.phone,
        old_password: account.phonePassword
    })
    if (status) {
        account.phone = ''
        account.phonePassword = ''
    }
    isPhoneLoading.value = false
}

async function updatePassword() {
    isPasswordLoading.value = true
    const status = await profileStore.updateUserData(ENV.APP_API_URL, {
        old_password: account.passwordOld,
        password: account.passwordNew
    })
    if (status) {
        account.passwordOld = ''
        account.passwordNew = ''
        account.passwordConfirm = ''
        account.passwordNewVisible = false
    }
    isPasswordLoading.value = false
}
</script>

<style scoped>

</style>
