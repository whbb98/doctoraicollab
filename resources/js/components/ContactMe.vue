<template>
    <v-container>
        <v-card>
            <v-card-title class="text-capitalize text-primary">contact me</v-card-title>
            <v-card-text>
                <v-list>
                    <v-list-item prepend-icon="mdi-phone">
                        0123456789
                    </v-list-item>
                    <v-list-item prepend-icon="mdi-email">
                        john-doe@gmail.com
                    </v-list-item>
                    <v-list-item prepend-icon="mdi-calendar">
                        <v-list-item class="text-capitalize">
                            <v-chip-group>
                                <v-chip>monday</v-chip>
                                <v-chip>friday</v-chip>
                            </v-chip-group>
                        </v-list-item>
                        <v-list-item>
                            <v-chip-group>
                                <v-chip>08:00</v-chip>
                                <v-chip>16:00</v-chip>
                            </v-chip-group>
                        </v-list-item>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>

</script>

<style scoped>

</style>
