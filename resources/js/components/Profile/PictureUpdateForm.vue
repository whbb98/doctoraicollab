<template>
    <v-form class="d-flex flex-column flex-sm-row align-center justify-space-between">
        <div style="width: 20%" v-if="photo" class="d-flex justify-center">
            <v-avatar class="mb-2" color="secondary" size="100" :image="pictureUrl">
                <span class="text-h5">AR</span>
            </v-avatar>
        </div >
        <div style="width: 20%" v-else-if="cover" class="d-flex justify-center">
            <v-img width="150" height="100" :src="pictureUrl"/>
        </div>
        <div class="description mb-2 d-flex flex-column justify-center">
            <h3 class="text-primary text-capitalize mb-2">
                <slot name="heading"/>
            </h3>
            <p class="text-dark text-capitalize mb-2">
                <slot name="uploadDescription"/>
            </p>
            <input :name="inputName" type="file" @change="renderImage">
        </div>
        <div class="actions d-flex flex-column">
            <v-btn class="mb-2" color="primary">upload</v-btn>
            <v-btn color="primary" variant="tonal">remove</v-btn>
        </div>
    </v-form>
</template>

<script setup>
import {ref} from "vue";

const props = defineProps({
    inputName: String,
    photo: Boolean,
    cover: Boolean
})
const pictureUrl = ref('https://i.pravatar.cc/50')

function renderImage(ev) {
    const file = ev.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onload = () => {
            pictureUrl.value = reader.result
        }
    }
}
</script>

<style scoped>
.description {
    width: 50%;
}
</style>
