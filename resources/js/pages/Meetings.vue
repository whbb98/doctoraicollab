<template>
    <v-card>
        <template #loader>
            <v-progress-linear
            v-if="isMeetingsLoading"
            color="primary"
            :indeterminate="isMeetingsLoading"
            />
        </template>
        <v-card-title class="font-weight-bold text-capitalize text-primary">meetings</v-card-title>
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
                <template v-for="blog in blogs">
                    <v-col cols="12" sm="6" md="4" lg="3" xl="2"
                           v-if="filterBy == 'all' || blog.meeting.flag == filterBy">
                        <meeting-card :blog="blog" :key="blog.id"/>
                    </v-col>
                </template>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {inject, onMounted, reactive, ref} from "vue";
import MeetingCard from "@/components/MeetingCard.vue";
import {useBlogsStore} from "@/stores/blogsStore.js";

const ENV = inject('ENV')
const filterBy = ref('all')
const meetingsCount = reactive({
    all: 0,
    now: 0,
    past: 0,
    scheduled: 0
})
const isMeetingsLoading = ref(false)
const blogsStore = useBlogsStore()
const blogs = ref(blogsStore.getMeetingBlogs)

function updateCounters() {
    meetingsCount.all = blogs.value.length
    meetingsCount.now = blogs.value.filter(meeting => meeting.flag === 'now').length
    meetingsCount.past = blogs.value.filter(meeting => meeting.flag === 'past').length
    meetingsCount.scheduled = blogs.value.filter(meeting => meeting.flag === 'scheduled').length
}

onMounted(async () => {
    await refreshMeetings()
    // setTimeout(() => {
    //     meetings.value[0].flag = 'past'
    //     updateCounters()
    // }, 2000)
})

async function refreshMeetings() {
    isMeetingsLoading.value = true
    blogs.value = []
    await blogsStore.fetchBlogs(ENV.APP_API_URL)
    blogs.value = blogsStore.getMeetingBlogs
    updateCounters()
    isMeetingsLoading.value = false
}
</script>

<style scoped>

</style>
