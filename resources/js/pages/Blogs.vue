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
            <BlogForm/>
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

import {onMounted, reactive, ref} from "vue";
import BlogCard from "@/components/BlogCard.vue";
import BlogForm from "@/components/BlogForm.vue";

const filterBy = ref('all')
const blogs = [
    {
        id: 10,
        title: 'hello blog title',
        backgroundUrl: 'https://picsum.photos/600/200',
        description: 'Hello iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
            '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
            '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
            '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
            '                sonet.',
        createdAt: new Date().toDateString() + ' ' + '14:16',
        participants: 12,
        comments: 19,
        flag: 'pending'
    },
    {
        id: 11,
        title: 'hello blog title',
        backgroundUrl: 'https://picsum.photos/600/200',
        description: 'Hello iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
            '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
            '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
            '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
            '                sonet.',
        createdAt: new Date().toDateString() + ' ' + '14:16',
        participants: 12,
        comments: 19,
        flag: 'participating'
    },
    {
        id: 12,
        title: 'hello blog title',
        backgroundUrl: 'https://picsum.photos/600/200',
        description: 'Hello iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
            '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
            '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
            '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
            '                sonet.',
        createdAt: new Date().toDateString() + ' ' + '14:16',
        participants: 12,
        comments: 19,
        flag: 'participating'
    },
    {
        id: 13,
        title: 'hello blog title',
        backgroundUrl: 'https://picsum.photos/600/200',
        description: 'Hello iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
            '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
            '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
            '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
            '                sonet.',
        createdAt: new Date().toDateString() + ' ' + '14:16',
        participants: 12,
        comments: 19,
        flag: 'myBlog'
    },
    {
        id: 14,
        title: 'hello blog title',
        backgroundUrl: 'https://picsum.photos/600/200',
        description: 'Hello iaculis dictas. Deterruissetquaerendum quas instructior placerat perpetua error.\n' +
            '                Dictumaccusata massa salutatus doming. Aptentvis vidisse putent nonumy noluisse ridiculus cras inimicus\n' +
            '                pellentesque pharetra alienum voluptatum legere sadipscing. Sapienmovet corrumpit periculis vocent\n' +
            '                eripuit delectus adversarium liber quaeque varius dui aliquid nominavi suscipiantur potenti civibus dui\n' +
            '                sonet.',
        createdAt: new Date().toDateString() + ' ' + '14:16',
        participants: 12,
        comments: 19,
        flag: 'participating'
    }
]
const blogsCount = reactive({
    all: 0,
    myBlog: 0,
    participating: 0,
    pending: 0
})
function updateCounters(){
    blogsCount.all = blogs.length
    blogsCount.pending = blogs.filter(blog => blog.flag === 'pending').length
    blogsCount.participating = blogs.filter(blog => blog.flag === 'participating').length
    blogsCount.myBlog = blogs.filter(blog => blog.flag === 'myBlog').length
}
onMounted(() => {
   updateCounters()
})
</script>

<style scoped>

</style>
