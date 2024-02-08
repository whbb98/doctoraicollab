<template>
    <v-app-bar elevation="0" color="primary" title="Dr AI Collab" class="px-5">
        <v-avatar color="secondary"
                  class="mr-5" size="40"
                  :image="mainStore.getAuthUser.avatar">
            <span class="text-h5 text-uppercase">{{ mainStore.getUserNameAbbr }}</span>
        </v-avatar>
        <div>
            <v-btn variant="elevated" :loading="isLogoutLoading" color="secondary" @click="logoutHandler">
                <v-icon>mdi-logout</v-icon>
                logout
            </v-btn>
        </div>
    </v-app-bar>
    <v-navigation-drawer permanent expand-on-hover :rail="true" color="secondary">
        <v-list color="primary" class="text-capitalize text-dark py-0">
            <v-list-item to="/home" prepend-icon="mdi-home" title="Home"></v-list-item>
            <v-list-item to="/profile" prepend-icon="mdi-account-circle" title="Profile"/>
            <v-list-item to="/messages" prepend-icon="mdi-message" title="Messages">
                <template v-slot:append>
                    <v-badge
                        v-if="false"
                        color="dark"
                        content="14"
                        inline
                    ></v-badge>
                </template>
            </v-list-item>
            <v-list-item to="/notifications" prepend-icon="mdi-bell" title="Notifications">
                <template v-slot:append>
                    <v-badge
                        v-if="true"
                        color="dark"
                        content="14"
                        inline
                    ></v-badge>
                </template>
            </v-list-item>
            <v-list-item to="/blogs" prepend-icon="mdi-post" title="Blogs"/>
            <v-list-item to="/meetings" prepend-icon="mdi-calendar-clock" title="Meetings"/>
            <v-list-item to="/network" prepend-icon="mdi-account-group" title="Network"/>
        </v-list>
    </v-navigation-drawer>
    <v-main class="bg-secondary overflow-auto">
        <v-container>
            <router-view/>
        </v-container>
    </v-main>
</template>

<script setup>
import {useMainStore} from "@/stores/mainStore.js";
import {useRouter} from "vue-router";
import {inject, ref} from "vue";

const mainStore = useMainStore()
const router = useRouter()
const ENV = inject('ENV')
const isLogoutLoading = ref(false)
const emit = defineEmits(['openSnackbar'])

async function logoutHandler() {
    isLogoutLoading.value = true
    const logoutStatus = await mainStore.logout(ENV.APP_API_URL)
    emit('openSnackbar', logoutStatus)
    isLogoutLoading.value = false
}
</script>


<style>

.v-main {
    height: 100vh;
}
</style>
