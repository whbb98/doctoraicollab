<template>
    <v-container>
        <v-data-table :headers="headers"
                      :items="items"
                      class="text-capitalize"
                      show-select
                      item-value="id"
                      :sort-by="[{ key: 'period', order: 'desc' }]"
                      v-model="selectedRow"
        >
        </v-data-table>
        <v-btn class="text-capitalize" variant="outlined" color="warning">delete selected</v-btn>
    </v-container>
</template>

<script setup>

import {ref} from "vue";

const selectedRow = ref([])

const headers = [
    {
        title: 'name',
        key: 'name',
    },
    {
        title: 'type',
        key: 'type'
    },
    {
        title: 'organization',
        key: 'organization'
    },
    {
        title: 'period',
        key: 'period',
    },

]
const items = [
    {
        id: 98,
        name: 'Bsc Degree in Mathematics',
        type: 'education',
        organization: 'university of oran 1',
        period: new Date('1998-11-15'),

    },
    {
        id: 10,
        name: 'Msc Degree in Computer Science',
        type: 'education',
        organization: 'university of oran 1',
        period: new Date(Date() + 5000),

    },
    {
        id: 3,
        name: 'Bsc Degree in Mathematics',
        type: 'education',
        organization: 'university of oran 1',
        period: new Date('1998-11-15'),

    }
]

</script>


<style scoped>

</style>
