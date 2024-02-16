<template>
    <v-container class="d-flex align-center justify-space-between">
        <span class="text-h6 text-capitalize text-primary">experience history</span>
        <v-btn color="primary" variant="outlined" class="font-weight-bold">
            {{ selectedCareer ? 'update' : 'add new' }}
            <v-dialog
                persistent
                transition="dialog-bottom-transition"
                v-model="dialogCareerForm"
                activator="parent">
                <v-container>
                    <v-card class="overflow-y-auto">
                        <v-card-title class="text-capitalize text-primary">add new experience</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-form @submit.prevent="handleNewCareer">
                                    <v-row>
                                        <v-col cols="12">
                                            <v-select
                                                v-model="career.type"
                                                label="Type"
                                                :items="['education','reward','experience']"
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field v-model="career.name"
                                                          label="Career Name"
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field v-model="career.period" label="Period Date"
                                                          type="date"/>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Organization Name"
                                                          v-model="career.organization"/>
                                        </v-col>
                                    </v-row>
                                    <v-btn type="submit" color="primary" class="mr-2">Save</v-btn>
                                    <v-btn color="warning" variant="outlined" @click="dialogCareerForm = false">
                                        Cancel
                                    </v-btn>
                                </v-form>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-container>
            </v-dialog>
        </v-btn>
    </v-container>
</template>

<script setup>
import {inject, reactive, ref, watch} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const props = defineProps(['selectedCareer'])
const ENV = inject('ENV')
const profileStore = useProfileStore()
const dialogCareerForm = ref(false)
const career = reactive({
    id: null,
    type: '',
    name: '',
    period: '',
    organization: ''
})
watch(() => props.selectedCareer, (newVal) => {
    if (!newVal) {
        career.id = null
        career.type = ''
        career.name = ''
        career.period = ''
        career.organization = ''
        return
    }
    career.id = newVal.id
    career.type = newVal.type
    career.name = newVal.career_name
    career.period = newVal.period
    career.organization = newVal.organization
})

async function handleNewCareer() {
    const status = !career.id ?
        await profileStore.createNewCareer(ENV.APP_API_URL, career) :
        await profileStore.updateCareer(ENV.APP_API_URL, career)
    if (status) {
        for (let key in career) { //reset all values
            career[key] = ''
        }
        dialogCareerForm.value = false
    }
}
</script>

<style scoped>

</style>
