<template>
    <v-main class="overflow-y-auto py-10">
        <v-row align="center" justify="center">
            <v-col sm="8" md="7" lg="6">
                <v-card class="card-form" color="secondary" variant="elevated">
                    <template #loader>
                        <v-progress-linear
                            v-if="isSignupLoading"
                            :indeterminate="isSignupLoading"
                        />
                    </template>
                    <v-card-title align="center"
                                  class="text-h4 text-capitalize text-primary font-weight-bold my-5"
                    >
                        create new account
                    </v-card-title>
                    <v-card-text class="text-capitalize">
                        <v-form @submit.prevent>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.username"
                                        name="username"
                                        label="username"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.firstName"
                                        name="firstName"
                                        label="first name"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.lastName"
                                        name="lastName"
                                        label="last name"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.email"
                                        name="email"
                                        label="email address"
                                        prepend-icon="mdi-at"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.password"
                                        :type="isPasswordVisible?'text':'password'"
                                        name="password"
                                        label="your password"
                                        prepend-icon="mdi-lock"
                                    >
                                        <template #append-inner>
                                            <v-icon @click="isPasswordVisible=!isPasswordVisible">
                                                {{ isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'}}
                                            </v-icon>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.phone"
                                        name="phone"
                                        label="phone number"
                                        prepend-icon="mdi-phone"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        v-model="newUser.gender"
                                        name="gender"
                                        label="gender"
                                        prepend-icon="mdi-gender-male-female"
                                        :items="[{ title: 'Male', value: 'M' },{ title: 'Female', value: 'F' }]"
                                        item-text="title"
                                        item-value="value"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newUser.birthDate"
                                        type="date"
                                        name="birthDate"
                                        label="birth date"
                                        prepend-icon="mdi-calendar"
                                    />
                                </v-col>
                            </v-row>
                            <v-btn class="mr-2"
                                   color="primary"
                                   type="submit"
                                   @click="signupHandler"
                            >
                                signup
                            </v-btn>
                            <v-btn color="warning"
                                   variant="outlined"
                                   type="reset"
                                   class="mr-5"
                            >
                                reset
                            </v-btn>
                            <router-link class="text-decoration-none text-capitalize text-primary"
                                         to="/login">
                                already have an account
                            </router-link>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-main>
</template>

<script setup>
import {inject, reactive, ref} from "vue";
import {useAuthStore} from "@/stores/authStore.js";
import {useRouter} from "vue-router";

const ENV = inject('ENV')
const router = useRouter()
const isSignupLoading = ref(false)
const newUser = reactive({})
const authStore = useAuthStore()
const isPasswordVisible = ref(false)

async function signupHandler() {
    isSignupLoading.value = true
    const signupStatus = await authStore.signup(newUser, ENV.APP_API_URL)
    if (signupStatus) {
        router.push('/login')
    }
    isSignupLoading.value = false
}
</script>

<style scoped>
.card-form {
    //max-height: 70vh;
}
</style>
