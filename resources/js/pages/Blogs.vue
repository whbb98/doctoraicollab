<template>
    <v-card>
        <v-card-title class="font-weight-bold text-capitalize">blogs</v-card-title>
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
                <v-chip value="myBlogs" :variant="filterBy=='myBlogs'? 'elevated':'outlined'">
                    my blogs
                    <v-badge
                        color="dark"
                        :content="blogsCount.myBlogs"
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
            <v-btn rounded color="primary">
                new blog
            </v-btn>
        </v-card-text>
        <v-card-text>
            <v-row>
                <v-col cols="12" sm="6" md="4" lg="3" xl="2" v-for="i in 5">
                    <blog-card/>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>

import {reactive, ref, watch} from "vue";
import BlogCard from "@/components/BlogCard.vue";

const filterBy = ref('all')
const blogsCount = reactive({
    all: 12,
    myBlogs: 2,
    participating: 6,
    pending: 3
})
watch(filterBy, (newValue) => {
    console.log(newValue)
})
</script>

<style scoped>

</style>
