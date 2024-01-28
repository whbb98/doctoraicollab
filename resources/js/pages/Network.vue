<template>
    <v-card>
        <v-card-title class="font-weight-bold text-capitalize text-primary">users network</v-card-title>
        <v-card-text>
            <v-form class="text-capitalize">
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="10">
                        <v-text-field
                            name="search"
                            label="type a username or email"
                            prepend-icon="mdi-account-search"
                        />
                    </v-col>
                    <v-col cols="12" sm="4" md="2" class="d-flex justify-center">
                        <v-btn color="primary" type="submit">
                            <v-icon>mdi-magnify</v-icon>
                            Search
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="6" md="3">
                        <v-select
                            prepend-icon="mdi-city"
                            name="city"
                            label="city"
                            :items="cities"
                            item-value="id"
                            item-title="name"
                            chips
                            color="primary"
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            name="hospital"
                            label="hospital"
                            prepend-icon="mdi-hospital-building"
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            name="department"
                            label="department"
                            prepend-icon="mdi-domain"
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-text-field
                            name="occupation"
                            label="occupation"
                            prepend-icon="mdi-doctor"
                        />
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-text>
            <v-card variant="flat">
                <v-card-title class="text-primary text-capitalize font-weight-bold">
                    <v-icon>mdi-text-search</v-icon>
                    search results:
                </v-card-title>
                <v-row>
                    <v-col v-for="user in users">
                        <profile-card :user="user" :key="user.username"/>
                    </v-col>
                </v-row>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script setup>

import ProfileCard from "@/components/ProfileCard.vue";

const users = [
    {
        username: 'ouahab98',
        name: 'abdelouahab radja',
        city: 'oran',
        hospital: 'CHO',
        department: 'pneumology',
        occupation: 'assistant',
        profileImgUrl: 'https://i.pravatar.cc/50',
        profileBackgroundUrl: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'
    },
    {
        username: 'ouahab15',
        name: 'abdelouahab radja',
        city: 'oran',
        hospital: 'CHO',
        department: 'pneumology',
        occupation: 'assistant',
        profileImgUrl: 'https://i.pravatar.cc/50',
        profileBackgroundUrl: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'
    },
    {
        username: 'ouahab11',
        name: 'abdelouahab radja',
        city: 'oran',
        hospital: 'CHO',
        department: 'pneumology',
        occupation: 'assistant',
        profileImgUrl: 'https://i.pravatar.cc/50',
        profileBackgroundUrl: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'
    },
    {
        username: 'ouahab12',
        name: 'abdelouahab smahi',
        city: 'oran',
        hospital: 'CHO',
        department: 'pneumology',
        occupation: 'assistant',
        profileImgUrl: '',
        profileBackgroundUrl: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'
    }
]


const cities = [
    {
        id:31,
        name:'Oran'
    },
    {
        id:32,
        name:'El bayadh'
    }
]
</script>

<style scoped>

</style>
