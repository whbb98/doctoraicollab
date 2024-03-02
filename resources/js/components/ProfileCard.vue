<template>
    <v-col>
        <v-container align="center" fluid>
            <v-card variant="outlined" color="primary">
                <v-card-title>
                    <v-img cover class="profile-cover mb-5 bg-primary" :src="profile.cover">
                        <v-avatar class="profile-avatar"
                                  color="secondary"
                                  size="100"
                                  :image="profile.photo">
                            <span class="text-h5 text-uppercase">{{ abbreviatedName }}</span>
                        </v-avatar>
                    </v-img>
                </v-card-title>
                <v-card-title class="text-capitalize">
                    {{ fullName }}
                </v-card-title>
                <v-card-text class="py-0">
                    <v-list class="text-capitalize py-0 text-left">
                        <v-list-item prepend-icon="mdi-doctor">{{ profile.occupation }}</v-list-item>
                        <v-list-item prepend-icon="mdi-domain">{{ profile.department }}</v-list-item>
                        <v-list-item prepend-icon="mdi-hospital-building">{{ profile.hospital }}</v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker">{{ profile.city }}</v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-actions class="py-0">
                    <v-btn color="primary"
                           class="text-capitalize"
                           prepend-icon="mdi-card-account-details">
                        view
                    </v-btn>
                    <v-btn class="text-capitalize"
                           prepend-icon="mdi-plus-circle">
                        follow
                    </v-btn>
                    <v-btn class="text-capitalize"
                           prepend-icon="mdi-message">
                        message
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-container>
    </v-col>
</template>

<script setup>
import {computed, onMounted} from "vue";

const props = defineProps(['profile'])

const fullName = computed(() => {
    return props.profile.user.firstName + ' ' + props.profile.user.lastName
})
const abbreviatedName = computed(() => {
    const user = props.profile.user
    return user.firstName.charAt(0) + user.lastName.charAt(0)
})

</script>

<style scoped>
.v-card {
    width: 300px;
}

.profile-cover {
    position: relative;
    overflow: visible;
    height: 150px;
}

.profile-avatar {
    position: absolute;
    top: 50%;
    left: 50%;
    translate: -50%;
}
</style>
