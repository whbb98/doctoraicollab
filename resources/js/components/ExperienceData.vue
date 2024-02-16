<template>
    <v-container>
        <v-data-table :headers="headers"
                      :items="items"
                      class="text-capitalize"
                      show-select
                      item-value="id"
                      :sort-by="[{ key: 'period', order: 'desc' }]"
                      v-model="selectedRow"
                      select-strategy="single"
        >
        </v-data-table>
        <v-btn v-if="selectedRow.length>0"
               class="text-capitalize"
               variant="elevated"
               color="error"
               @click="handleDeleteCareer"
        >
            delete
        </v-btn>
    </v-container>
</template>

<script setup>

import {computed, inject, ref, watch} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const emit = defineEmits(['selectRow'])
const ENV = inject('ENV')
const selectedRow = ref([])
let selectedRowObj = null
const profileStore = useProfileStore()
const headers = [
    {
        title: 'name',
        key: 'career_name',
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
const items = computed(() => {
    return profileStore.getAuthUserProfile.career
})

watch(selectedRow, (newVal) => {
    const selectedItem = items.value.find(item => item.id === newVal[0])
    selectedRowObj = selectedItem
    emit('selectRow', selectedItem)
})

function handleDeleteCareer() {
    if (selectedRowObj) {
        const status = profileStore.deleteCareer(ENV.APP_API_URL, selectedRowObj.id)
        if (status) {
            selectedRow.value = []
        }
    }
}
</script>


<style scoped>

</style>
