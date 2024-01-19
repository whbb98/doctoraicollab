<template>
    <v-card color="secondary">
        <v-card-title class="pa-0">
            <v-img height="200" cover src="https://picsum.photos/600/200">
                <template #placeholder>
                    <div class="d-flex align-center justify-center fill-height">
                        <v-progress-circular
                            color="primary"
                            indeterminate
                        ></v-progress-circular>
                    </div>
                </template>
            </v-img>
        </v-card-title>
        <v-card-text class="text-capitalize mt-3 py-0">
            <h3 class="mb-2">blog title</h3>
            <p class="mb-3">
                {{ truncatedDescription }}
            </p>
            <span class="d-flex align-center">
                <v-icon>mdi-calendar</v-icon>
                {{ new Date().toDateString() }} 14:31
            </span>
        </v-card-text>
        <v-card-actions>
            <span class="d-flex align-center mr-5">
                <v-icon>mdi-account-group</v-icon>
                12
            </span>
            <span class="d-flex align-center">
                <v-icon>mdi-comment-multiple-outline</v-icon>
                15
            </span>
            <v-spacer/>
            <router-link to="/blogs/id" class="text-capitalize text-decoration-none text-primary">read more
            </router-link>
        </v-card-actions>
    </v-card>
</template>

<script setup>

import {computed, ref} from "vue";

const description = ref(
    'Atomorummetus iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
    '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
    '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
    '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
    '                sonet.'
)
const maxLength = 100
const truncatedDescription = computed(() => {
    if (description.value.length <= maxLength) {
        return description.value
    } else {
        return description.value.slice(0, maxLength) + '...'
    }
})
</script>

<style scoped>

</style>
