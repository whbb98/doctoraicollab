<template>
    <v-main class="overflow-auto">
        <v-row class="parent" align="center" justify="center">
            <v-col sm="8" md="7" lg="6">
                <v-card color="secondary" variant="elevated">
                    <template #loader>
                        <v-progress-linear
                            v-if="isLoginLoading"
                            :indeterminate="isLoginLoading"
                        />
                    </template>
                    <v-card-title align="center"
                                  class="text-h4 text-capitalize text-primary font-weight-bold my-5"
                    >
                        account login
                    </v-card-title>
                    <v-card-text class="text-capitalize">
                        <v-form @submit.prevent>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="username"
                                        name="user"
                                        label="email or username"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="userpass"
                                        type="password"
                                        name="password"
                                        label="your password"
                                        prepend-icon="mdi-lock"
                                    />
                                </v-col>
                            </v-row>
                            <v-btn class="mr-2"
                                   color="primary"
                                   type="submit"
                                   @click="loginHandler"
                            >
                                login
                            </v-btn>
                            <v-btn color="warning"
                                   variant="outlined"
                                   type="reset"
                                   class="mr-5"
                            >
                                reset
                            </v-btn>
                            <router-link class="text-decoration-none text-capitalize text-primary"
                                         to="/signup">
                                i don't have an account !
                            </router-link>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-main>
</template>

<script setup>
import {inject, ref} from "vue";
import {useAuthStore} from "@/stores/authStore.js";
import {useRouter} from "vue-router";

const ENV = inject('ENV')
const username = ref(null)
const userpass = ref(null)
const isLoginLoading = ref(false)
const emit = defineEmits(['openSnackbar'])
const authStore = useAuthStore()
const router = useRouter()

async function loginHandler() {
    isLoginLoading.value = true
    const loginStatus = await authStore.login(username.value, userpass.value, ENV.APP_API_URL)
    emit('openSnackbar', loginStatus)
    if(authStore.getAuthToken){
        router.push('/home')
    }
    isLoginLoading.value = false
}
</script>

<style scoped>
.parent {
    height: 90vh;
}
</style>
