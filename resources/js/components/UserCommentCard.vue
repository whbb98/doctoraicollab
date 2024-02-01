<template>
    <v-card-text>
        <v-card-title>
            <v-avatar class="mr-2" color="secondary" size="50" :image="userComment.avatar">
                <span class="text-h5 text-uppercase">{{ userComment.nameAbbr }}</span>
            </v-avatar>
            <span class="text-capitalize">{{ userComment.fullName }}</span>
        </v-card-title>
        <v-card-subtitle>{{ userComment.commentDate }}</v-card-subtitle>
        <v-card-text>
            {{userComment.commentText}}
        </v-card-text>
    </v-card-text>
</template>

<script setup>
const props = defineProps(['userComment'])
</script>

<style scoped>

</style>
