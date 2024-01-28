<template>
    <v-main class="overflow-auto">
        <v-row align="center" justify="center">
            <v-col sm="8" md="7" lg="6">
                <v-card color="secondary" variant="elevated">
                    <v-card-title align="center"
                                  class="text-h4 text-capitalize text-primary font-weight-bold my-5"
                    >
                        create new account
                    </v-card-title>
                    <v-card-text class="text-capitalize">
                        <v-form @submit.prevent>
                            <v-row justify="center">
                                <v-col cols="12">
                                    <v-text-field
                                        name="username"
                                        label="username"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        name="firstName"
                                        label="first name"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        name="lastName"
                                        label="last name"
                                        prepend-icon="mdi-account"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        name="email"
                                        label="email address"
                                        prepend-icon="mdi-at"
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
                                <v-col cols="12">
                                    <v-text-field
                                        name="phone"
                                        label="phone number"
                                        prepend-icon="mdi-phone"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        name="gender"
                                        label="gender"
                                        prepend-icon="mdi-gender-male-female"
                                        :items="['male','female']"
                                        :item-value="['M','F']"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        type="date"
                                        name="birthDate"
                                        label="birth date"
                                        prepend-icon="mdi-calendar"
                                    />
                                </v-col>
                            </v-row>
                            <v-btn class="mr-2"
                                   color="primary"
                                   type="submit"
                                   @click="$router.push('/signin')"
                            >
                                signup
                            </v-btn>
                            <v-btn color="warning"
                                   variant="outlined"
                                   type="reset"
                                   class="mr-5"
                            >
                                reset
                            </v-btn>
                            <router-link class="text-decoration-none text-capitalize text-primary"
                                         to="/login">
                                already have an account
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

</style>
