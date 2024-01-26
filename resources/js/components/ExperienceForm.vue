<template>
    <v-container class="d-flex align-center justify-space-between">
        <span class="text-h6 text-capitalize text-primary">experience history</span>
        <v-btn color="primary" variant="outlined" class="font-weight-bold">
            Add new
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
                                <v-form @submit.prevent>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-select
                                                name="careerType"
                                                label="Type"
                                                :items="['education','reward','experience']"
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field name="careerName" label="Career Name"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field readonly name="careerPeriod" label="Period Date"
                                                          v-model="careerDate">
                                                <v-dialog v-model="dialogDatePicker" activator="parent">
                                                    <v-container class="w-auto">
                                                        <v-card width="fit-content">
                                                            <v-card-text>
                                                                <v-date-picker v-model="careerDate"></v-date-picker>
                                                            </v-card-text>
                                                            <v-card-actions class="text-capitalize">
                                                                <v-btn color="primary" variant="outlined"
                                                                       @click="dialogDatePicker=false">Ok
                                                                </v-btn>
                                                                <v-btn color="warning" variant="outlined"
                                                                       @click="careerDate=null; dialogDatePicker=false">Clear
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-container>
                                                </v-dialog>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Organization Name" name="organization"></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-btn type="submit" color="primary" class="mr-2">Save</v-btn>
                                    <v-btn color="warning" variant="outlined" @click="dialogCareerForm = false">Cancel
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
import {ref} from "vue";

const dialogCareerForm = ref(false)
const careerDate = ref(null)
const dialogDatePicker = ref(false)
</script>

<style scoped>

</style>
