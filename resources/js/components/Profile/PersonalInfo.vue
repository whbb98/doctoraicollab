<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">personal information</v-card-title>
            <v-card-text>
                <PictureUpdateForm photo inputName="profilePhoto">
                    <template #heading>
                        upload your personal photo
                    </template>
                    <template #uploadDescription>
                        make sure that photo is personal and your face is clear
                    </template>
                </PictureUpdateForm>
                <v-spacer class="mb-2"/>
                <PictureUpdateForm cover inputName="profilePhoto">
                    <template #heading>
                        upload a cover picture
                    </template>
                </PictureUpdateForm>
                <v-container>
                    <v-form>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary" name="firstName"
                                              class="text-capitalize" label="first name" :disabled="!editMode"/>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary" name="lastName" class="text-capitalize"
                                              label="last name" :disabled="!editMode"/>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary" name="email" class="text-capitalize"
                                              label="email address" :disabled="!editMode"/>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field color="primary" name="phone" class="text-capitalize" label="phone N°"
                                              :disabled="!editMode"/>
                            </v-col>
                            <v-col>
                                <v-textarea color="primary" name="bio" class="text-capitalize" label="about"
                                            :disabled="!editMode"/>
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
                </v-container>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import PictureUpdateForm from "@/components/Profile/PictureUpdateForm.vue";
import {ref} from "vue";

const editMode = ref(false)

</script>

<style scoped>

</style>
