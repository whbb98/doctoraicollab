<template>
    <v-card>
        <v-card-title class="font-weight-bold text-capitalize">meetings</v-card-title>
        <v-card-text class="d-flex align-center">
            <v-chip-group
                class="text-capitalize"
                color="primary"
                variant="elevated"
                mandatory
                v-model="filterBy"
            >
                <v-chip value="all" :variant="filterBy=='all'? 'elevated':'outlined'">
                    all
                    <v-badge
                        color="dark"
                        :content="meetingsCount.all"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="now" prepend-icon="mdi-broadcast" :variant="filterBy=='now'? 'elevated':'outlined'">
                    now
                    <v-badge
                        color="dark"
                        :content="meetingsCount.now"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="past" :variant="filterBy=='past'? 'elevated':'outlined'">
                    past
                    <v-badge
                        color="dark"
                        :content="meetingsCount.past"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="scheduled" :variant="filterBy=='scheduled'? 'elevated':'outlined'">
                    scheduled
                    <v-badge
                        color="dark"
                        :content="meetingsCount.scheduled"
                        inline
                    ></v-badge>
                </v-chip>
            </v-chip-group>
        </v-card-text>
        <v-card-text>
            <v-row>
                <template v-for="meeting in meetings">
                    <v-col cols="12" sm="6" md="4" lg="3" xl="2"
                           v-if="filterBy == 'all' || meeting.flag == filterBy">
                        <meeting-card :meeting="meeting" :key="meeting.id"/>
                    </v-col>
                </template>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {onMounted, reactive, ref} from "vue";
import MeetingCard from "@/components/MeetingCard.vue";

const filterBy = ref('all')
const meetingsCount = reactive({
    all: 0,
    now: 0,
    past: 0,
    scheduled: 0
})

function updateCounters() {
    meetingsCount.all = meetings.length
    meetingsCount.now = meetings.filter(meeting => meeting.flag === 'now').length
    meetingsCount.past = meetings.filter(meeting => meeting.flag === 'past').length
    meetingsCount.scheduled = meetings.filter(meeting => meeting.flag === 'scheduled').length
}

const meetings = reactive([
    {
        id: 1,
        blogTitle: 'this is meeting title',
        datetime: 'jan 16 2024 14:53',
        duration: 24,
        participants: 8,
        url: 'https://www.google.com',
        backgroundUrl: 'https://picsum.photos/600/200',
        flag: 'now'
    }
])
onMounted(() => {
    updateCounters()
    setTimeout(() => {
        meetings[0].flag = 'past'
        updateCounters()
    }, 2000)
})
</script>

<style scoped>

</style>
