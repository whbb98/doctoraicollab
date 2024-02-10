<template>
    <PostForm @open-snackbar="openSnackBar"/>
    <PostCard/>
</template>

<script setup>

import PostForm from "@/components/PostForm.vue";
import PostCard from "@/components/PostCard.vue";

3
const emit = defineEmits(['openSnackbar'])

function openSnackBar(payload) {
    emit('openSnackbar', payload)
}
</script>

<style scoped>

</style>
