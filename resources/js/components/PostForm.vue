<template>
    <v-form @submit.prevent="uploadPost" class="mb-5">
        <v-card rounded="51">
            <v-card-title class="text-capitalize">share new post</v-card-title>
            <v-card-text>
                <v-textarea rows="3" clearable label="Post Description" prepend-icon="mdi-text"></v-textarea>
                <v-file-input multiple clearable chips color="primary" label="Post Attachments"></v-file-input>
                <v-switch color="primary" label="Visible to All" prepend-icon="mdi-earth"></v-switch>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" type="submit">share
                    <v-icon>mdi-upload</v-icon>
                </v-btn>
                <v-btn color="warning" type="reset">clear
                    <v-icon>mdi-cancel</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script setup>
function uploadPost() {
    alert('uploaded')
}
</script>

<style scoped>

</style>
