<template>
    <h1>Meetings Page</h1>
    <p>{{ENV.APP_URL}}</p>
</template>

<script setup>
import {inject} from "vue";

const ENV = inject('ENV')
</script>

<style scoped>

</style>
