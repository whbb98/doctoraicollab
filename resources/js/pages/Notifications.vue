<template>
    <v-card>
        <v-card-title class="font-weight-bold text-primary text-capitalize d-flex align-center">
            notifications
        </v-card-title>
        <v-card-text>
            <v-chip-group
                class="text-capitalize"
                color="primary"
                variant="elevated"
                v-model="filterBy"
                mandatory
                on-update:model-value="">
                <v-chip value="all"
                        :variant="filterBy === 'all' ? 'elevated' : 'outlined'">
                    all
                </v-chip>
                <v-chip value="unread"
                        :variant="filterBy === 'unread' ? 'elevated' : 'outlined'"
                        :disabled="unreadCount <= 0"
                >
                    unread
                    <v-badge
                        v-if="unreadCount > 0"
                        color="dark"
                        :content="unreadCount"
                        inline
                    ></v-badge>
                </v-chip>
            </v-chip-group>
            <v-list>
                <template v-for="item in dummyData">
                    <v-list-item :key="item.id"
                                 v-if="filterBy=='all' || (filterBy=='unread' && !item?.isRead)"
                    >
                        <notification-card
                            :notification="item"
                            @markAsRead="markAsReadHandler"/>
                    </v-list-item>
                </template>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {reactive, ref} from "vue";
import NotificationCard from "@/components/NotificationCard.vue";

const filterBy = ref('all')
const unreadCount = ref(0)
const dummyData = reactive([
    {
        id: '1',
        sender: 'John Doe',
        message: 'praesent impetus vestibulum porro quaestio no appareat pharetra.',
        isRead: false,
        createdAt: '16 Jan 2024 at 14:32'
    },
    {
        id: '2',
        sender: 'Amine Smahi',
        message: 'praesent impetus vestibulum porro quaestio no appareat pharetra.',
        isRead: true,
        createdAt: '16 Jan 2024 at 14:32'
    },
    {
        id: '3',
        sender: 'Radja Abdelouahab',
        message: 'praesent impetus vestibulum porro quaestio no appareat pharetra.',
        isRead: false,
        createdAt: '16 Jan 2024 at 14:32'
    },
    {
        id: '4',
        sender: 'Nafissa Rahali',
        message: 'praesent impetus vestibulum porro quaestio no appareat pharetra.',
        isRead: true,
        createdAt: '16 Jan 2024 at 14:32'
    }
])

unreadCount.value = dummyData.filter(item => item.isRead === false).length

function markAsReadHandler(notificationID) {
    const notification = dummyData.find(item => item.id === notificationID)
    notification.isRead = true
    unreadCount.value--
}
</script>

<style scoped>

</style>
