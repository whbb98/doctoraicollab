<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">
                notifications settings
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <v-checkbox v-for="item in notificationsList"
                                        :key="item.name"
                                        class="text-capitalize text-high-emphasis"
                                        :disabled="!editMode"
                                        color="primary"
                                        :label="item.description"
                            style="color:red"
                            />
                        </v-col>
                    </v-row>
                    <v-btn class="mr-1" color="primary">
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
import {notificationsList} from "@/utils/constants.js";

const editMode = ref(false)

</script>

<style scoped>

</style>
