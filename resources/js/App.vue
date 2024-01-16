<template>
    <v-app>
        <v-app-bar elevation="0" color="primary" title="Dr AI Collab" class="px-5">
            <v-avatar color="secondary" class="mr-5" size="40">
                <span class="text-h5">AR</span>
            </v-avatar>
            <div>
                <v-btn color="secondary" @click="console.log('bye !')">
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
<!--        <v-footer app color="dark">-->
<!--            <h1>footer </h1>-->
<!--        </v-footer>-->
    </v-app>
</template>

<script setup>
import {provide, ref, reactive} from "vue";

const ENV = {
    APP_URL: import.meta.env.VITE_APP_URL,
    APP_API: import.meta.env.VITE_APP_API
}
provide('ENV', ENV)

</script>


<style>
#app {
    overflow: hidden !important;
}

.v-main {
    height: 100vh;
}
</style>
