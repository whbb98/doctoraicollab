<template>
    <v-card>
        <v-card-title class="font-weight-bold text-capitalize d-flex align-center">
            notifications
        </v-card-title>
        <v-card-text>
            <v-chip-group
                class="text-capitalize"
                color="primary"
                variant="elevated"
                v-model="filterBy"
                on-update:model-value="">
                <v-chip value="all"
                        :variant="filterBy === 'all' ? 'elevated' : 'outlined'">
                    all
                </v-chip>
                <v-chip value="unread"
                        :variant="filterBy === 'unread' ? 'elevated' : 'outlined'">
                    unread
                    <v-badge
                        v-if="true"
                        color="dark"
                        content="12"
                        inline
                    ></v-badge>
                </v-chip>
            </v-chip-group>
            <v-list>
                <v-list-item>
                    <notification-card/>
                </v-list-item>
                <v-list-item>
                    <notification-card/>
                </v-list-item>
                <v-list-item>
                    <notification-card/>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {ref} from "vue";
import NotificationCard from "@/components/NotificationCard.vue";

const filterBy = ref('all')

</script>

<style scoped>

</style>
