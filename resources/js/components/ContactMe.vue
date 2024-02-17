<template>
    <v-container>
        <v-card>
            <v-card-title class="text-capitalize text-primary">contact me</v-card-title>
            <v-card-text>
                <v-list>
                    <v-list-item prepend-icon="mdi-phone">
                        {{ contactData.phone }}
                    </v-list-item>
                    <v-list-item prepend-icon="mdi-email">
                        {{ contactData.email }}
                    </v-list-item>
                    <v-list-item prepend-icon="mdi-calendar">
                        <v-list-item class="text-capitalize">
                            <v-chip-group>
                                <v-chip>{{ contactData.from_day }}</v-chip>
                                <v-chip>{{ contactData.to_day }}</v-chip>
                            </v-chip-group>
                        </v-list-item>
                        <v-list-item>
                            <v-chip-group>
                                <v-chip>{{ contactData.from_time }}</v-chip>
                                <v-chip>{{ contactData.to_time }}</v-chip>
                            </v-chip-group>
                        </v-list-item>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import {useProfileStore} from "@/stores/profileStore.js";
import {computed} from "vue";

const profileStore = useProfileStore()
const contactData = computed(() => {
    return profileStore.getAuthUserProfile.contact
})
</script>

<style scoped>

</style>
