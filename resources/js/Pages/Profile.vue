<template>
    <v-card>
        <v-card-title class="text-capitalize">
            <v-avatar color="secondary" size="100" class="mr-5" image="https://i.pravatar.cc/50">
                <span class="text-h5">AR</span>
            </v-avatar>
            <span>john doe</span>
        </v-card-title>
        <v-card-text class="text-capitalize">
            <v-list bg-color="transparent">
                <v-list-item>
                    <div class="d-flex align-center">
                        <v-icon color="primary" class="mr-2">mdi-doctor</v-icon>
                        <span>position</span>
                    </div>
                </v-list-item>
                <v-list-item>
                    <div class="d-flex align-center">
                        <v-icon color="primary" class="mr-2">mdi-hospital-building</v-icon>
                        <span>university hospital of oran</span>
                    </div>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
    <v-card class="mt-1">
        <v-tabs
            grow
            align-tabs="center"
            v-model="tab"
            bg-color="secondary">
            <v-tab value="overview" color="primary">
                <v-icon class="mr-1">mdi-account-box</v-icon>
                Overview
            </v-tab>
            <v-tab value="experience" color="primary">
                <v-icon class="mr-1">mdi-school</v-icon>
                Experience
            </v-tab>
            <v-tab value="contact" color="primary">
                <v-icon class="mr-1">mdi-card-account-mail</v-icon>
                Contact
            </v-tab>
            <v-tab value="settings" color="primary">
                <v-icon class="mr-1">mdi-cog</v-icon>
                Settings
            </v-tab>
        </v-tabs>
        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="overview">
                    <v-list>
                        <v-list-item>
                            <v-card>
                                <v-card-title class="text-capitalize text-primary">bio</v-card-title>
                                <v-card-text class="text-dark">Aliquamsuscipit mel prodesset. Graecimea quem rutrum
                                    finibus maiestatis
                                    feugait ad nonumes natoque platea disputationi nihil. Persequerisfalli epicurei
                                    euismod ocurreret sit sonet dolores comprehensam fabellas. Magnislibero gloriatur
                                    petentium consetetur persecuti nec risus movet ei salutatus. Egetcurabitur iusto
                                    facilis legimus suscipiantur mollis viris per legere duis no graeco vel nisi.
                                </v-card-text>
                            </v-card>
                        </v-list-item>
                        <v-list-item>
                            <v-card>
                                <v-card-actions class="justify-space-between text-capitalize">
                                    <span class="d-flex align-center">
                                        <v-icon
                                        class="text-primary mr-1">mdi-map-marker</v-icon>
                                        oran
                                    </span>
                                    <span class="d-flex align-center">
                                        <v-icon class="text-primary mr-1">mdi-domain</v-icon>
                                        penumology
                                    </span>
                                    <span class="d-flex align-center">
                                        <v-icon
                                        class="text-primary mr-1">mdi-calendar-account</v-icon>
                                        nov 2023
                                    </span>
                                </v-card-actions>
                            </v-card>
                        </v-list-item>
                        <v-list-item>
                            <span class="mr-5"><b>15</b> following</span>
                            <span><b>30</b> followers</span>
                        </v-list-item>
                        <v-list-item>
                            <v-card>
                                <v-card-title class="text-primary">Followers</v-card-title>
                                <v-row>
                                    <profile-card v-for="i in 5"/>
                                </v-row>
                            </v-card>
                        </v-list-item>
                    </v-list>
                </v-window-item>

                <v-window-item value="experience">
                    <ExperienceForm/>
                    <ExperienceData/>
                </v-window-item>

                <v-window-item value="contact">
                    Contact
                </v-window-item>

                <v-window-item value="settings">
                    Settings
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {ref} from "vue";
import ProfileCard from "@/Components/ProfileCard.vue";
import ExperienceForm from "@/Components/ExperienceForm.vue";
import ExperienceData from "@/Components/ExperienceData.vue";

const tab = ref(null)
</script>

<style scoped>

</style>
