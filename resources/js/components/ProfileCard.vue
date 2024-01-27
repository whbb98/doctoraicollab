<template>
    <v-col>
        <v-container align="center" fluid>
            <v-card variant="outlined" color="primary">
                <v-card-title>
                    <v-img class="profile-cover mb-5" :src="user.profileBackgroundUrl">
                        <v-avatar class="profile-avatar"
                                  color="secondary"
                                  size="100"
                                  :image="user.profileImgUrl">
                            <span class="text-h5">{{ nameAcronym }}</span>
                        </v-avatar>
                    </v-img>
                </v-card-title>
                <v-card-title class="text-capitalize">{{ user.name }}</v-card-title>
                <v-card-text class="py-0">
                    <v-list align="start" class="text-capitalize py-0">
                        <v-list-item prepend-icon="mdi-doctor">{{ user.occupation }}</v-list-item>
                        <v-list-item prepend-icon="mdi-domain">{{ user.department }}</v-list-item>
                        <v-list-item prepend-icon="mdi-hospital-building">{{ user.hospital }}</v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker">{{ user.city }}</v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-actions class="py-0">
                    <router-link :to="`/profile/${user.username}`">
                        <v-btn color="primary" class="text-capitalize" prepend-icon="mdi-card-account-details">view</v-btn>
                    </router-link>
                    <v-btn class="text-capitalize" prepend-icon="mdi-plus-circle">
                        follow
                    </v-btn>
                    <v-btn class="text-capitalize"
                           prepend-icon="mdi-message"
                           @click="console.log('messaging is not supported !')"
                    >
                        message
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-container>
    </v-col>
</template>

<script setup>
import {computed, onMounted} from "vue";

const props = defineProps(['user'])

const nameAcronym = computed(() => {
    return props.user.name.split(' ')[0].charAt(0).toUpperCase() + props.user.name.split(' ')[1].charAt(0).toUpperCase()
})

</script>

<style scoped>
.v-card {
    width: 300px;
}

.profile-cover {
    position: relative;
    overflow: visible;
}

.profile-avatar {
    position: absolute;
    top: 60%;
    left: 50%;
    translate: -50%;
}
</style>
