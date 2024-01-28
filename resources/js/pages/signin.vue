<template>
    <v-main class="overflow-auto">
        <v-row class="parent" align="center" justify="center">
            <v-col sm="8" md="7" lg="6">
                <v-card color="secondary" variant="elevated">
                    <v-card-title align="center"
                                  class="text-h4 text-capitalize text-primary font-weight-bold my-5"
                    >
                        account login
                    </v-card-title>
                    <v-card-text class="text-capitalize">
                        <v-form @submit.prevent>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <v-text-field
                                        name="user"
                                        label="email or username"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        type="password"
                                        name="password"
                                        label="your password"
                                        prepend-icon="mdi-lock"
                                    />
                                </v-col>
                            </v-row>
                            <v-btn class="mr-2"
                                   color="primary"
                                   type="submit"
                                   @click="$router.push('/')"
                            >
                                login
                            </v-btn>
                            <v-btn color="warning"
                                   variant="outlined"
                                   type="reset"
                                   class="mr-5"
                            >
                                reset
                            </v-btn>
                            <router-link class="text-decoration-none text-capitalize text-primary"
                                         to="/signup">
                                i don't have an account !
                            </router-link>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-main>
</template>

<script setup>

</script>

<style scoped>
.parent{
    height: 90vh;
}
</style>
