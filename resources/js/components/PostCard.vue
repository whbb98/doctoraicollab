<template>
    <v-card>
        <v-card-title>
            <v-avatar class="mr-2" color="secondary" size="50" image="https://i.pravatar.cc/50">
                <span class="text-h5">AR</span>
            </v-avatar>
            <span>john doe</span>
        </v-card-title>
        <v-card-subtitle>{{ new Date() }}</v-card-subtitle>
        <v-list title="Attachments" class="d-flex">
            <v-list-item prepend-icon="mdi-file">file one</v-list-item>
            <v-list-item prepend-icon="mdi-file">file two</v-list-item>
        </v-list>
        <v-container class="d-flex">
            <v-carousel show-arrows="hover">
                <v-carousel-item
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    cover
                ></v-carousel-item>

                <v-carousel-item
                    src="https://cdn.vuetifyjs.com/images/cards/hotel.jpg"
                    cover
                ></v-carousel-item>

                <v-carousel-item
                    src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                    cover
                ></v-carousel-item>
            </v-carousel>
        </v-container>
        <v-card-text>
            Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta nisl dico
            aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.
        </v-card-text>
        <v-card-actions>
            <v-btn :color="true?'red':'primary'">
                <v-icon>mdi-heart</v-icon>
                {{ true ? 'Liked' : 'Like' }}
            </v-btn>
            <v-btn color="primary">
                <v-icon>mdi-share</v-icon>
                share
            </v-btn>
            <v-btn color="primary" :active="isCommentOpen" @click="isCommentOpen = !isCommentOpen">
                <v-icon>mdi-comment</v-icon>
                comments
            </v-btn>
        </v-card-actions>
        <v-card v-if="isCommentOpen">
            <v-container>
                <v-form @submit.prevent class="d-flex align-center">
                    <v-text-field name="comment" clearable label="Your Comment"
                                  prepend-icon="mdi-comment"></v-text-field>
                </v-form>
            </v-container>
            <v-container class="comments">
                <user-comment-card v-for="item in userComments" :userComment="item"/>
            </v-container>
        </v-card>
    </v-card>
</template>

<script setup>
import {ref} from "vue";
import UserCommentCard from "@/components/UserCommentCard.vue";

const isCommentOpen = ref(false)

const userComments = [
    {
        id: 1,
        nameAbbr: 'AR',
        fullName: 'abdelouahab radja',
        avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 2,
        nameAbbr: 'AS',
        fullName: 'amine smahi',
        avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 3,
        nameAbbr: 'ob',
        fullName: 'oussama bonnor',
        // avatar: 'https://i.pravatar.cc/50',
        commentDate: new Date().toDateString() + '14:52',
        commentText: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    }
]
</script>

<style scoped>
.comments {
    max-height: 200px;
    overflow: auto;
}
</style>
