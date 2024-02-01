<template>
    <v-app>
        <router-view/>
        <v-footer order="0" app color="dark">
            <h1>footer</h1>
        </v-footer>
    </v-app>

</template>

<script setup>
import {provide} from "vue";

const ENV = {
    APP_URL: import.meta.env.VITE_APP_URL,
    APP_API: import.meta.env.VITE_APP_API,
    AUTH_TOKEN: '43|jhGxfJbz7EDNs4V3k92CUcedKpAZDKtzuMkQfqHOcce8a333'
}
provide('ENV', ENV)
</script>


<style>
#app {
    //overflow: hidden !important;
}

</style>
