<template>
    <v-card>
        <template #loader>
            <v-progress-linear
                v-if="isLoadingBlogs"
                color="primary"
                :indeterminate="isLoadingBlogs"
            />
        </template>
        <v-card-title class="font-weight-bold text-capitalize text-primary">blogs</v-card-title>
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
                        :content="blogsCount.all"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="myBlog" :variant="filterBy=='myBlog'? 'elevated':'outlined'">
                    my blogs
                    <v-badge
                        color="dark"
                        :content="blogsCount.myBlog"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="participating" :variant="filterBy=='participating'? 'elevated':'outlined'">
                    participating
                    <v-badge
                        color="dark"
                        :content="blogsCount.participating"
                        inline
                    ></v-badge>
                </v-chip>
                <v-chip value="pending" :variant="filterBy=='pending'? 'elevated':'outlined'">
                    pending
                    <v-badge
                        color="dark"
                        :content="blogsCount.pending"
                        inline
                    ></v-badge>
                </v-chip>
            </v-chip-group>
            <v-spacer/>
            <BlogForm @create-blog="refreshBlogs"/>
        </v-card-text>
        <v-card-text>
            <v-row>
                <template v-for="blog in blogs">
                    <v-col cols="12" sm="6" md="4" lg="3" xl="2"
                           v-if="filterBy == 'all' || blog.flag == filterBy">
                        <blog-card :blog="blog" :key="blog.id"/>
                    </v-col>
                </template>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>

import {inject, onMounted, reactive, ref, watch} from "vue";
import BlogCard from "@/components/BlogCard.vue";
import BlogForm from "@/components/BlogForm.vue";
import {useBlogsStore} from "@/stores/blogsStore.js";

const ENV = inject('ENV')
const blogsStore = useBlogsStore()
const filterBy = ref('all')
const blogs = ref(blogsStore.getBlogs)
const isLoadingBlogs = ref(false)
const blogsCount = reactive({
    all: 0,
    myBlog: 0,
    participating: 0,
    pending: 0
})

function updateCounters() {
    blogsCount.all = blogs.value.length
    blogsCount.pending = blogs.value.filter(blog => blog.flag === 'pending').length
    blogsCount.participating = blogs.value.filter(blog => blog.flag === 'participating').length
    blogsCount.myBlog = blogs.value.filter(blog => blog.flag === 'myBlog').length
}

onMounted(async () => {
    await refreshBlogs()
})

async function refreshBlogs() {
    isLoadingBlogs.value = true
    blogs.value = []
    await blogsStore.fetchBlogs(ENV.APP_API_URL)
    blogs.value = blogsStore.getBlogs
    updateCounters()
    isLoadingBlogs.value = false
}
</script>

<style scoped>

</style>
