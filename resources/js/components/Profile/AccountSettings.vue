<template>
    <v-container>
        <v-card>
            <v-card-title class="text-primary text-capitalize">
                account settings
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            email update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field readonly class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-email"
                                          label="current email"
                                          model-value="old-email@gmail.com"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-email"
                                          name="email"
                                          label="new email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          name="password"
                                          label="password"
                                          type="password"
                            />
                        </v-col>
                    </v-row>
                    <v-btn color="primary">
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                </v-form>
            </v-card-text>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            phone Number update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field readonly class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-phone"
                                          label="current phone number"
                                          model-value="old-email@gmail.com"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-phone"
                                          name="phone"
                                          label="new phone number"
                                          :rules="validateDigits"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          name="password"
                                          label="password"
                                          type="password"
                            />
                        </v-col>
                    </v-row>
                    <v-btn color="primary">
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                </v-form>
            </v-card-text>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-card-title class="text-primary text-capitalize text-h6">
                            password update
                        </v-card-title>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          name="current_password"
                                          label="current password"
                                          type="password"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          name="new_password"
                                          label="new password"
                                          type="password"
                                          v-model="newPassword"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field class="text-capitalize"
                                          color="primary"
                                          prepend-icon="mdi-lock"
                                          name="confirm_password"
                                          label="confirm new password"
                                          type="password"
                                          v-model="confirmPassword"
                                          :rules="[validatePassword]"
                            />
                        </v-col>
                    </v-row>
                    <v-btn color="primary">
                        <v-icon>mdi-content-save-outline</v-icon>
                        save
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
import {validateDigits} from "@/utils/validateRules.js";
import {ref, watch} from "vue";

const newPassword = ref(null)
const confirmPassword = ref(null)

function validatePassword(val) {
    return newPassword.value === confirmPassword.value || 'Password does not much'
}

</script>

<style scoped>

</style>
