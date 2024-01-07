<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">career information</v-card-title>
            <v-card-text>
                <v-form @submit.prevent>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-wallet-travel" class="text-capitalize" color="primary" name="occupation" label="occupation" :disabled="!editMode"/>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-office-building" class="text-capitalize" color="primary" name="department" label="department" :disabled="!editMode"/>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-hospital-building" class="text-capitalize" color="primary" name="hospital" label="hospital" :disabled="!editMode"/>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field prepend-icon="mdi-map-marker" class="text-capitalize" color="primary" name="city" label="city" :disabled="!editMode"/>
                        </v-col>
                    </v-row>
                    <v-btn type="submit" class="mr-1" color="primary">
                        <v-icon>mdi-content-save</v-icon>
                        save
                    </v-btn>
                    <v-btn color="primary" variant="outlined" @click="editMode=!editMode">
                        <v-icon>mdi-square-edit-outline</v-icon>
                        edit
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import {ref} from "vue";

const editMode = ref(false)
</script>

<style scoped>

</style>
