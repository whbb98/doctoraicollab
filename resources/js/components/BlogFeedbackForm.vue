<template>
    <v-dialog
        persistent
        transition="dialog-bottom-transition"
        v-model="feedbackDialog"
        activator="parent">
        <v-container>
            <v-card class="feedback-container overflow-y-auto pt-2">
                <v-card-title class="d-flex text-capitalize text-primary">
                    <v-icon>mdi-square-edit-outline</v-icon>
                    blog feedback Choices
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-form @submit.prevent="loadICDSuggestions">
                                    <v-text-field
                                        prepend-icon="mdi-magnify"
                                        append-inner-icon="mdi-keyboard-return"
                                        v-model="ICDQuery"
                                        label="Disease Keyword"
                                        @click:clear="clearFeedback(false)"
                                        clearable/>
                                </v-form>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    :label="`Disease ICD Suggestions (${ICDSuggestionList.length})`"
                                    color="primary"
                                    prepend-icon="mdi-format-list-checks"
                                    v-model="ICDSelectedList"
                                    :loading="isLoadingSuggestions"
                                    :items="ICDSuggestionList"
                                    item-title="id"
                                    item-value="id"
                                    multiple
                                    hide-selected
                                    chips
                                >
                                    <template v-slot:item="{ props, item }">
                                        <v-list-item @click="addICDChip(item.raw)" v-bind="props"
                                                     :subtitle="item.raw.description"/>
                                    </template>
                                </v-select>
                            </v-col>
                            <v-col class="mb-5" cols="12">
                                <v-card variant="text">
                                    <v-card-title class="d-flex align-center text-capitalize text-primary">
                                        selected choices ({{ ICDSelectedChips.length }})
                                        <v-btn class="ml-5"
                                               rounded
                                               color="primary"
                                               variant="outlined"
                                               @click="clearFeedback(true)"
                                        >
                                            reset all
                                        </v-btn>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-chip-group>
                                            <v-chip v-for="(item) in ICDSelectedChips"
                                                    :key="item.id"
                                                    @click:close="deleteICDChip(item.id)"
                                                    closable>
                                                {{ item.id }}
                                                <v-tooltip activator="parent"
                                                           location="top">
                                                    {{ item.description }}
                                                </v-tooltip>
                                            </v-chip>
                                        </v-chip-group>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-btn type="submit"
                               color="primary"
                               class="mr-2"
                               @click="saveFeedback"
                        >
                            Save
                        </v-btn>
                        <v-btn color="warning" variant="outlined" @click="feedbackDialog = false">
                            Cancel
                        </v-btn>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-container>
    </v-dialog>
</template>

<script setup>
import {computed, inject, reactive, ref, watch} from "vue";
import {useRoute} from "vue-router";
import axios from "axios";

const emit = defineEmits(['updateFeedback'])
const route = useRoute()
const feedbackDialog = ref(false)
const ENV = inject('ENV')
const ICD_AUTO_COMPLETE_URL = ENV.APP_API + 'blogs/' + route.params.blogID + '/icd10_auto_complete'
const token = ENV.AUTH_TOKEN
const ICDQuery = ref('')
const ICDSelectedList = ref([])
const ICDSuggestionList = ref([])
const isLoadingSuggestions = ref(false)
const ICDSelectedChips = ref([])

function addICDChip(item) {
    ICDSelectedChips.value.push(item)
}

function deleteICDChip(key) {
    ICDSelectedChips.value = ICDSelectedChips.value.filter(item => item.id !== key)
    ICDSelectedList.value = ICDSelectedList.value.filter(item => item !== key)
}

function clearFeedback(isAll) {
    if (isAll) {
        ICDSuggestionList.value = []
        ICDSelectedList.value = []
        ICDSelectedChips.value = []
    } else {
        ICDSuggestionList.value = []
        ICDSelectedList.value = []
    }
}

function loadICDSuggestions() {
    isLoadingSuggestions.value = true
    ICDSuggestionList.value = []
    axios.get(ICD_AUTO_COMPLETE_URL, {
        headers: {Authorization: `Bearer ${token}`},
        params: {q: ICDQuery.value}
    }).then(response => {
        ICDSuggestionList.value.push(...response.data)
        isLoadingSuggestions.value = false
    }).catch(error => {
        console.error("Error while fetching data", error)
        isLoadingSuggestions.value = false
    })
}

function saveFeedback() {
    emit('updateFeedback', ICDSelectedChips.value)
    feedbackDialog.value = false
}
</script>

<style scoped>
.feedback-container {
    max-height: 90vh;
}
</style>
