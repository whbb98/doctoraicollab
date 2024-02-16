<template>
    <v-container class="d-flex align-center justify-space-between">
        <span class="text-h6 text-capitalize text-primary">update contact form</span>
        <v-btn color="primary" variant="outlined" class="font-weight-bold">
            update
            <v-dialog
                persistent
                transition="dialog-bottom-transition"
                v-model="dialogContactForm"
                activator="parent">
                <v-container>
                    <v-card class="overflow-y-auto">
                        <v-card-title class="text-capitalize text-primary">update contact form</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-form @submit.prevent validate-on="input">
                                    <v-row>
                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="contactForm.phone"
                                                prepend-icon="mdi-phone"
                                                name="phone"
                                                label="work phone"
                                                clearable/>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="contactForm.email"
                                                :rules="validateEmail"
                                                prepend-icon="mdi-email"
                                                name="email"
                                                label="work email"
                                                clearable/>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-select
                                                v-model="contactForm.from_day"
                                                class="text-capitalize"
                                                prepend-icon="mdi-calendar"
                                                name="from_day"
                                                label="From Day"
                                                :items="weekDays"
                                                clearable/>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-select
                                                v-model="contactForm.to_day"
                                                class="text-capitalize"
                                                prepend-icon="mdi-calendar"
                                                name="to_day"
                                                label="To Day"
                                                :items="weekDays"
                                                clearable/>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="contactForm.from_time"
                                                class="text-capitalize"
                                                prepend-icon="mdi-clock"
                                                name="from_time"
                                                label="from time"
                                                type="time"
                                                clearable/>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="contactForm.to_time"
                                                class="text-capitalize"
                                                prepend-icon="mdi-clock"
                                                name="to_time"
                                                label="to time"
                                                type="time"
                                                clearable/>
                                        </v-col>
                                    </v-row>
                                    <v-btn type="submit" color="primary" class="mr-2">Save</v-btn>
                                    <v-btn color="warning" variant="outlined" @click="dialogContactForm = false">Cancel
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
import {reactive, ref} from "vue";
import {weekDays} from "@/utils/constants.js";
import {validateEmail} from "@/utils/validateRules.js";

const dialogContactForm = ref(false)
const contactForm = reactive({
    email: null,
    phone: null,
    from_day: null,
    to_day: null,
    from_time: null,
    to_time: null
})

</script>

<style scoped>

</style>
