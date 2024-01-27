<template>
    <v-card>
        <v-card-title class="text-capitalize font-weight-bold">
            {{route.params.blogID}}
        </v-card-title>
    </v-card>
</template>

<script setup>
import {useRoute, useRouter} from "vue-router";

const route = useRoute()
</script>

<style scoped>

</style>
