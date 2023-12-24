<template>
    <v-col>
        <v-container align="center" fluid>
            <v-card variant="outlined" color="primary">
                <v-card-title>
                    <v-img class="profile-cover mb-5" src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg">
                        <v-avatar class="profile-avatar" color="secondary" size="100" image="https://i.pravatar.cc/50">
                            <span class="text-h5">AR</span>
                        </v-avatar>
                    </v-img>
                </v-card-title>
                <v-card-title class="text-capitalize">john doe</v-card-title>
                <v-card-text class="py-0">
                    <v-list align="start" class="text-capitalize py-0">
                        <v-list-item prepend-icon="mdi-doctor">occupation</v-list-item>
                        <v-list-item prepend-icon="mdi-domain">department name</v-list-item>
                        <v-list-item prepend-icon="mdi-hospital-building">hospital name</v-list-item>
                        <v-list-item prepend-icon="mdi-map-marker">city</v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-actions class="py-0">
                    <v-btn class="text-capitalize" prepend-icon="mdi-card-account-details">view</v-btn>
                    <v-btn class="text-capitalize" prepend-icon="mdi-plus-circle">follow</v-btn>
                    <v-btn class="text-capitalize" prepend-icon="mdi-message">message</v-btn>
                </v-card-actions>
            </v-card>
        </v-container>
    </v-col>
</template>

<script setup>

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
